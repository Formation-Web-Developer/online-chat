<?php
use NeutronStars\Database\Database;

function getMessages(Database $database, int $channel): array
{
    return $database->query('messages')
                    ->select('*')
                    ->where('channel=:channel')
                    ->setParameters([':channel' => $channel])
                    ->getResults();
}

function createMessage(Database $database, int $channel, string $author, string $message): void
{
    $database->query('messages')
             ->insertInto('channel, author, message,created_at', ':channel,:author,:message,NOW()')
             ->setParameters([
                 ':channel' => $channel,
                 ':author'  => $author,
                 ':message' => $message
             ])->execute();
}
