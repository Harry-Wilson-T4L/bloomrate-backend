const express = require('express');
const app = express();
var fs = require('fs');
require('dotenv').config();

// HTTPS Configuration (comment for local testing)
const options = {
    key: fs.readFileSync('/etc/letsencrypt/live/admin.bloomrate.com/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/admin.bloomrate.com/fullchain.pem'),
};
const server = require('https').createServer(options, app);

// // HTTP Configuration for local testing
// const server = require('http').createServer(app);

// Enable CORS for HTTP requests (required for browser fetch/ajax)
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    
    // Handle preflight requests
    if (req.method === 'OPTIONS') {
        return res.sendStatus(200);
    }
    
    next();
});

// Enable JSON Parsing
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

var io = require('socket.io')(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST", "PATCH", "DELETE"],
        credentials: true,
        transports: ['websocket', 'polling'],
        allowEIO3: false
    },
});

var mysql = require("mysql");

var con_mysql = mysql.createPool({
    host: "localhost",
    user: "user_bloomrate",
    password: "8ME£Dj$0£Pn6",
    database: "bloomrate",
    debug: true,
    charset: 'utf8mb4'
});

var FCM = require('fcm-node');
var serverKey = 'AAAARtHAFkk:APA91bHPCwemOxQQYftfn2n5TPD505lmoh-HyiM6cw8dr1dmKREUm9j-C_YQdT1q5G0pi7miBEasQPIQclAQGnwOmSwITYnOk0Kj0pX40ZE_RIhyM-tG4PhdXqxd180Q-9skwKli7p8m';
var fcm = new FCM(serverKey);


// SOCKET START
io.on('connection', function (socket) {
    

    console.log('socket connection *** ', socket.connected)

    // NEW www
    socket.on("user_join", function (object) {
        // Join Users
        var user_room = "user_" + object.user_id;
        socket.join(user_room);

        console.log(`User ${object.user_id} joined room: ${user_room}`);
    });

    // API to receive notifications from Laravel
    app.post("/send-notification", (req, res) => {
        try {
            console.log("Incoming request body:", req.body);

            const { user_id, type, data } = req.body;

            if (!user_id || !type || data === undefined) {
                return res.status(400).json({ error: "Invalid request data" });
            }

            const userRoom = `user_${user_id}`;
            io.to(userRoom).emit("response", { object_type: type, data });

            console.log(`Sent notification count to ${userRoom}:`, data);
            res.json({ success: true, message: "Notification sent successfully!" });

        } catch (error) {
            console.error("Error in /send-notification:", error);
            res.status(500).json({ error: "Internal Server Error" });
        }
    });

    // User Online
        const userId = socket.handshake.query.userId;
        con_mysql.query(`UPDATE users SET online_status = 'online' WHERE id = ?`, [userId], function (error) {
            
            if (error) {
                console.log("Error updating online status:", error);
            } else {
                console.log("User set to online:", userId);
            }
        });
    // GET MESSAGES EMIT

    socket.on('chat_list', function (object) {
        var user_room = "user_" + object.user_id;
        socket.leave(user_room);
        socket.join(user_room);

        chat_list(object, function (response) {
            if (response) {
                console.log("chat_list has been successfully executed...");
                io.to(user_room).emit('response', { object_type: "chat_list", data: response });
            } else {
                console.log("chat_list has been failed...");
                io.to(user_room).emit('error', { object_type: "chat_list", message: "There is some problem in chat_list..." });
            }
        });
    });


    socket.on('get_messages', function (object) {
        var sender_room = "user_" + object.sender_id;
        socket.join(sender_room);

        get_messages(object, function (response) {
            if (response) {
                console.log("get_messages has been successfully executed...");
                io.to(sender_room).emit('response', { object_type: "get_messages", data: response });
            } else {
                console.log("get_messages has been failed...");
                io.to(sender_room).emit('error', { object_type: "get_messages", message: "There is some problem in get_messages..." });
            }
        });
    });
    
    //GET GROUP MESSAGE 
    socket.on('group_get_messages', function(object) {
        var group_room = "group_" + object.group_id;
        var sender = "user_" + object.sender_id;
        socket.join(group_room);
        socket.join(sender);
        group_get_messages(object, function(response) {
            if (response) {
                console.log("get_messages has been successfully executed...");
                io.to(sender).emit('response', { object_type: "get_messages", data: response });
            } else {
                console.log("get_messages has been failed...");
                io.to(group_room).emit('error', { object_type: "get_messages", message: "There is some problem in get_messages..." });
            }
        });
    });

    // DELETE GROUP MESSAGE EMIT
    socket.on("delete_group_message", function (object) {
        var group_chat_id = object.group_chat_id;
        var sender_room = "user_" + object.user_id;
        var group_room = "group_" + object.group_id;
        delete_group_message(object, function (response) {
            io.to(sender_room).to(group_room).emit("response", {
                object_type: "delete_group_message",
                data: group_chat_id,
            });
        });
    });

    // DELETE MESSAGE EMIT
   socket.on("delete_message", function (object) {
        var chat_id = object.chat_id;
        var sender_room = "user_" + object.sender_id;
        var receiver_room = "user_" + object.receiver_id;
        delete_message(object, function (response) {
            io.to(sender_room).to(receiver_room).emit("response", {
                object_type: "delete_message",
                data: chat_id,
            });
        });
    });

    // SEND MESSAGE EMIT
    socket.on('send_message', function (object) {
        var sender_room = "user_" + object.sender_id;
        var receiver_room = "user_" + object.receiver_id;        

        send_message(object, function (response) {
            if (response) {
                // io.to(receiver_room).emit('response', { object_type: "message_count", data: 0 });

                // Get unread message count of reciever by checking messages where read_at is null and reciever_id is the reciever
                con_mysql.query(`SELECT COUNT(id) AS unread_count FROM chats WHERE receiver_id = ${object.receiver_id} AND read_at IS NULL`, function (error, countData) {
                    if (error) {
                        console.error("Error fetching unread count:", error);
                    } else {
                        const unreadCount = countData[0].unread_count;
                        io.to(receiver_room).emit('response', { object_type: "message_count", data: unreadCount });
                    }
                });
                
                if (response[0]['device_token'] == null) {
                    io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                    console.log("Successfully sent with response: ");
                } else {

                    
                    var full_name = response[0]['full_name'];
                    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
                        to: response[0]['device_token'],
                        collapse_key: 'your_collapse_key',

                        notification: {
                            title: 'Chat Notification',
                            body: full_name + ' Sent you a message',
                            user_name: full_name,
                            notification_type: 'chat',
                            other_id: object.sender_id,
                            vibrate: 1,
                            sound: 1
                        },

                        data: {  //you can send only notification or only data(or include both)
                            title: 'Chat Notification',
                            body: full_name + ' Sent you a message',
                            user_name: full_name,
                            notification_type: 'chat',
                            other_id: object.sender_id,
                            vibrate: 1,
                            sound: 1
                        }
                    };

                    fcm.send(message, function (err, response_two) {
                        if (err) {
                            console.log("Something has gone wrong!");
                            io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                        } else {
                            io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                            console.log("Successfully sent with response: ", response_two);
                        }
                    });

                    
                }
            } else {
                console.log("send_message has been failed...");
                io.to(sender_room).emit('error', { object_type: "get_message", message: "There is some problem in get_message..." });
            }
        });
    });
    
       //SEND GROUP MESSAGE Chat
    socket.on('group_send_message', function(object) {
        var group_room = "group_" + object.group_id;
        socket.join(group_room);
        group_send_message(object, function(response) {
                if (response) {
            
                var g_device_token = response[0]['g_device_token'].split(',');
                 var full_name = response[0]['full_name'];

                var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
                    registration_ids: g_device_token, 
                    collapse_key: 'your_collapse_key',
                    
                    notification: {
                        title:'Group Chat Notification',
                        body: full_name + ' Sent you a message',
                        user_name: full_name,
                        notification_type:'group_chat',
                        other_id:object.group_id,
                        vibrate:1,
                        sound:1
                    },
                    
                    data: {  //you can send only notification or only data(or include both)
                        title:'Group Chat Notification',
                        body: full_name + ' Sent you a message',
                        user_name: full_name,
                        notification_type:'group_chat',
                        other_id:object.group_id,
                        vibrate:1,
                        sound:1
                    }
                };
                
                fcm.send(message, function(err, response_two){
                    if (err) {
                        console.log("Something has gone wrong!", err);
                        io.to(group_room).emit('response', { object_type: "get_message", data: response[0] });
                    } else {
                        io.to(group_room).emit('response', { object_type: "get_message", data: response[0] });
                        console.log("Successfully sent with response: ");
                    }
                });
            } else {
                console.log("send_message has been failed...");
                io.to(group_room).emit('error', { object_type: "get_message", message: "There is some problem in get_messages..." });
            }
        });
    });

    socket.on('read_messages', async function (object) {
        try {
            var user_room = "user_" + object.sender_id;
            const response = await read_messages(object);

            if (response) {
                console.log("read_message success...");
                io.to(user_room).emit('response', { object_type: "read_messages" });
            } else {
                console.log("read_message failed error...");
            }

        } catch (err) {
            console.log("read_message error...", err);
        }
    });

    socket.on('is_typing', function () {
        var receiver_room = "user_" + object.receiver_id;
        io.to(receiver_room).emit('response', { object_type: object.type });
    });

    socket.on('disconnect', function () {
        console.log("Use disconnection", socket.id)

        // user Offline
        con_mysql.query(`UPDATE users SET online_status = 'offline' WHERE id = ?`, [userId], function (error) {
            if (error) {
                console.log("Error updating offline status:", error);
            } else {
                console.log("User set to offline:", userId);
            }
        });
    });
});
// SOCKET END

// GET MESSAGES FUNCTION
var chat_list = function (object, callback) {
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`
            SELECT 
                user_id, 
                full_name, 
                user_name, 
                profile_image, 
                message, 
                created_at, 
                type, 
                unread_count, 
                online_status
            FROM
                (
                    (
                        SELECT
                users.id AS user_id,
                users.full_name,
                users.user_name,
                users.profile_image,
                users.online_status,
                (SELECT COUNT(id) 
                 FROM chats AS st 
                 WHERE (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                   AND st.read_at IS NULL) AS unread_count,
                (SELECT message 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY id DESC LIMIT 1) AS message,
                (SELECT type 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY created_at DESC LIMIT 1) AS type,
                (SELECT created_at 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY created_at DESC LIMIT 1) AS created_at
            FROM chats
                LEFT JOIN users ON users.id = chats.sender_id
            WHERE chats.receiver_id = ${object.user_id} 
              AND chats.deleted_at IS NULL 
              AND chats.group_id IS NULL
        )
        UNION
        (
            SELECT
                users.id AS user_id,
                users.full_name,
                users.user_name,
                users.profile_image,
                users.online_status,
                (SELECT COUNT(id) 
                 FROM chats AS st 
                 WHERE (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                   AND st.read_at IS NULL) AS unread_count,
                (SELECT message 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY id DESC LIMIT 1) AS message,
                (SELECT type 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY created_at DESC LIMIT 1) AS type,
                (SELECT created_at 
                 FROM chats AS st 
                 WHERE (st.sender_id = ${object.user_id} AND st.receiver_id = users.id) 
                    OR (st.sender_id = users.id AND st.receiver_id = ${object.user_id}) 
                 ORDER BY created_at DESC LIMIT 1) AS created_at
            FROM chats
                LEFT JOIN users ON users.id = chats.receiver_id
            WHERE chats.sender_id = ${object.user_id} 
              AND chats.deleted_at IS NULL 
              AND chats.group_id IS NULL
        )
        ) AS p_pn
            GROUP BY 
                user_id, 
                full_name, 
                user_name, 
                profile_image, 
                unread_count, 
                message, 
                created_at, 
                type, 
                online_status
            ORDER BY created_at DESC;`, function (error, data) {
                            connection.release();
                if (error) {
                    callback(false);
                } else {
                    callback(data);
                }
            });
        }
    });
};

var get_messages = function (object, callback) {
    // console.log("Send msf call bacj")
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            connection.query(`UPDATE chats SET read_at = NOW() WHERE chats.sender_id = ${object.receiver_id} AND chats.receiver_id = ${object.sender_id} AND read_at IS NULL`, function (error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    connection.query(`select 
                    users.id as user_id,
                    users.full_name,
                    users.user_name,
                    users.profile_image, 
                    chats.id, 
                    chats.sender_id,
                    chats.receiver_id, 
                    chats.message,
                    chats.thumbnail,
                    chats.type,
                    chats.created_at
                    from chats 
                    inner join users          on chats.sender_id = users.id
                    WHERE 
                    (
                        (chats.sender_id = ${object.sender_id}   AND chats.receiver_id = ${object.receiver_id}) OR 
                        (chats.sender_id = ${object.receiver_id} AND chats.receiver_id = ${object.sender_id})
                    ) AND chats.deleted_at IS NULL
                    group by chats.id ORDER BY chats.id ASC;`, function (error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });
                }
            });
        }
    });
};

// SEND MESSAGE FUNCTION
var send_message = function (object, callback) {
    // console.log("Send msf call bacj")
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            var new_message = mysql_real_escape_string(object.message);

            if (object.parent_id != undefined) {
                var parent_id = object.parent_id
            } else {
                var parent_id = 0;
            }

            if (object.thumbnail != undefined) {
                var thumbnail = object.thumbnail
            } else {
                var thumbnail = '';
            }

            connection.query(`INSERT INTO chats (sender_id, receiver_id, message, thumbnail, type, parent_id, created_at) VALUES ('${object.sender_id}', '${object.receiver_id}', '${new_message}', '${thumbnail}', '${object.chat_type}', '${parent_id}', NOW())`, 
                function (error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    console.log("update_list has been successfully executed...");
                    connection.query(`select 
                            users.id as user_id,
                            users.full_name,
                            users.user_name,
                            users.profile_image, 
                            (select device_token from users where id = '${object.receiver_id}') as device_token,
                            chats.id, 
                            chats.sender_id,
                            chats.receiver_id, 
                            chats.message,
                            chats.thumbnail,
                            chats.type,
                            chats.created_at        
                            from chats 
                            inner join users          on chats.sender_id = users.id
                            WHERE  (chats.id = ${data.insertId})`, function (error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });
                }
            });
        }
    });
};

// READ MESSAGE FUNCTION
var read_messages = async function (object) {
    return new Promise((resolve, reject) => {
        con_mysql.getConnection(function (error, connection) {
            if (error) {
                reject(error);
            } else {
                connection.query(`UPDATE chats SET read_at = NOW() WHERE chats.sender_id = ${object.receiver_id} AND chats.receiver_id = ${object.sender_id} AND read_at IS NULL`, function (error, data) {
                    connection.release();
                    if (error) {
                        console.log("read_messages query error...", error)
                        reject(error);
                    } else {
                        resolve(data);
                    }
                });
            }
        });
    });
}

//GROUP MESSAGE
var group_get_messages = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select 
            users.full_name,
            users.user_name,
            users.profile_image, 
            chats.id as chat_id, 
            chats.sender_id,
            chats.group_id,
            chats.message,
            chats.type,
            chats.created_at
            from chats 
            inner join users on chats.sender_id = users.id
            WHERE chats.group_id=${object.group_id} order by chats.id ASC`, function(error, data) {
                connection.release();
                if (error) {
                    callback(false);
                } else {
                    callback(data);
                }
            });
        }
    });
};

//SEND GROUP MESSAGE
var group_send_message = function (object, callback) {
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            var new_message = mysql_real_escape_string(object.message);
            connection.query(`INSERT INTO chats (sender_id,group_id,message,type,created_at) VALUES ('${object.sender_id}' , '${object.group_id}', '${new_message}','${object.type}',NOW())`, function (error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    console.log("update_list has been successfully executed...");
                    connection.query(`SELECT 
                        u.full_name,
                        u.profile_image, 
                        u.device_token,
                        u.user_name,
                        c.*,
                        GROUP_CONCAT(g_users.device_token) as g_device_token
                        FROM users AS u
                        JOIN chats AS c
                        ON u.id = c.sender_id
                        
                        inner join group_members on group_members.group_id = c.group_id
                        inner join users as g_users on g_users.id = group_members.user_id
                        
                        WHERE group_members.group_id = ${object.group_id} AND c.id = '${data.insertId}'`, function (error, data) {

                        // WHERE c.chat_id = '${data.insertId}'`, function(error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });

                }
            });
        }
    });
};

 // Group Message Delete
 var delete_group_message = function (object, callback) {
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE");
            callback(false);
        } else {
            connection.query(
                `delete from chats where id = '${object.group_chat_id}'`,
                function (error, data) {
                    if (error) {
                        console.log("FAILED TO VERIFY LIST");
                        callback(false);
                    } else {
                        callback(true);
                    }
                }
            );
        }
    });
};

// Message Delete
var delete_message = function (object, callback) {
    con_mysql.getConnection(function (error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE");
            callback(false);
        } else {
            connection.query(
                `delete from chats where id = '${object.chat_id}'`,
                function (error, data) {
                    if (error) {
                        console.log("FAILED TO VERIFY LIST");
                        callback(false);
                    } else {
                        callback(true);
                    }
                }
            );
        }
    });
};



function mysql_real_escape_string(str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
        switch (char) {
            case "\0":
                return "\\0";
            case "\x08":
                return "\\b";
            case "\x09":
                return "\\t";
            case "\x1a":
                return "\\z";
            case "\n":
                return "\\n";
            case "\r":
                return "\\r";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "\\" + char; // prepends a backslash to backslash, percent,
            // and double/single quotes
            default:
                return char;
        }
    });
}

// Set port from environment variable or default to 3002

// SERVER LISTENER
const PORT = process.env.PORT || 3002;

// Start the server
server.listen(PORT, function () {
    console.log(`Server is running on port ${PORT}`);
});
