<?php
use NeutronStars\Database\Database;

function getChannels(Database $database): array
{
    return $database->query('channels')
                    ->select('*')
                    ->orderBy('created_at', \NeutronStars\Database\Query::ORDER_BY_DESC)
                    ->getResults();
}

function createChannel(Database $database, string $author, string $channel): int
{
    $database->query('channels')
             ->insertInto('name,author,created_at', ':name,:author,NOW()')
             ->setParameters([
                 ':name' => $channel,
                 ':author' => $author
             ])->execute();
    return $database->getLastInsertId();
}

function getChannel(Database $database, int $id): ?array
{
    return $database->query('channels')
                    ->select('*')
                    ->where('id=:id')
                    ->setParameters([':id' => $id])
                    ->getResult();
}
