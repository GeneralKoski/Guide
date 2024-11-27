<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function insertChats($name, $type, mysqli $conn)
{
    $sql = 'INSERT INTO Chats (name, type, created_at) VALUES ';
    $sql .= " ('$name','$type', NOW()) ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

function insertChatUsers($user_id, $chat_id, mysqli $conn)
{
    $sql = 'INSERT INTO ChatUsers (user_id, chat_id, added_at) VALUES ';
    $sql .= " ('$user_id','$chat_id', NOW()) ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

function insertMessages($chat_id, $user_id, $content, $seen, mysqli $conn)
{
    $sql = 'INSERT INTO Messages (chat_id, user_id, content, sent_at, seen) VALUES ';
    $sql .= " ('$chat_id','$user_id', '$content', NOW(), '$seen') ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

function insertUsers($username, $icon, $last_access, mysqli $conn)
{
    $sql = 'INSERT INTO Users (username, icon, last_access) VALUES ';
    $sql .= " ('$username','$icon', '$last_access') ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

function insertUserSettings($user_id, $setting_name, $setting_value, mysqli $conn)
{
    $sql = 'INSERT INTO UserSettings (user_id, setting_name, setting_value, updated_at) VALUES ';
    $sql .= " ('$user_id','$setting_name', '$setting_value', NOW()) ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

function insertGroupChatMessage($chat_id, $message_id, $seen_by_user, $seen, mysqli $conn)
{
    $sql = 'INSERT INTO GroupChatMessages (chat_id, message_id, seen_by_user, seen) VALUES ';
    $sql .= " ('$chat_id','$message_id', '$seen_by_user', '$seen') ";

    $res = $conn->query($sql);
    if (!$res) {
        echo $conn->error . '<br>';
    }
}

// insertUsers('Papà', '', '2024-11-20 20:00:00.000000', $mysqli);

// insertChats('Gymbro con Valentina Nappi', 'single', $mysqli); 

// insertChatUsers("8", "21", $mysqli);
// insertChatUsers("14", "21", $mysqli);

// insertMessages('21', '14', 'Oggi posso fare squat su di te se vuoi', 'yes', $mysqli);

// insertUserSettings("19", 'ultimo_accesso', 'yes', $mysqli);
// insertUserSettings("19", 'conferme_lettura', 'yes', $mysqli);

// insertGroupChatMessage(12, 70, 8, 'yes', $mysqli);
// insertGroupChatMessage(12, 70, 16, 'yes', $mysqli);