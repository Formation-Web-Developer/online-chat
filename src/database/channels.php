<?php
use NeutronStars\Database\Database;

function getChannels(Database $database): array
{
    return $database->query('channels c')
                    ->select('c.*', 'IFNULL(m.messages, 0) messages')
                    ->leftJoinQuery(
                        (new \NeutronStars\Database\QueryBuilder('messages msg'))
                                ->select('msg.channel', 'COUNT(*) messages')
                                ->groupBy('msg.channel'),
                        'm',
                        'm.channel=c.id'
                    )
                    ->orderBy('c.created_at', \NeutronStars\Database\Query::ORDER_BY_DESC)
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
