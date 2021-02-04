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

function createMessage(Database $database, int $channel, string $author, string $message, ?string $data): void
{
    $database->query('messages')
             ->insertInto('channel, author, message, data, created_at', ':channel,:author,:message,:data,NOW()')
             ->setParameters([
                 ':channel' => $channel,
                 ':author'  => $author,
                 ':message' => $message,
                 ':data'    => $data
             ])->execute();
}
