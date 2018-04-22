<?php
require_once __DIR__ . '/SingletonTrait.php';
require_once __DIR__ . '/NewsModel.php';
require_once __DIR__ . '/Db.php';

class Repository
{
    use SingletonTrait;
    /**
     * @var Db
     */
    private $db;

    protected function init()
    {
        $this->db = Db::getInstance();
    }

    public function save(NewsModel $model)
    {
        $sql = 'insert ignore into news (`srcUrl`, `srcUrlHash`, `created`, `img`, `text`, `title`, `description`) values (:srcUrl, :srcUrlHash, :created, :img, :text, :title, :description)';
        $sth = $this->db->getDbh()->prepare($sql);
        $date = date('Y-m-d H:i:s', $model->created);
        $sth->bindParam(':created', $date);
        $sth->bindParam(':srcUrlHash', $model->srcUrlHash);
        $sth->bindParam(':srcUrl', $model->srcUrl);
        $sth->bindParam(':img', $model->img);
        $sth->bindParam(':text', $model->text);
        $sth->bindParam(':title', $model->title);
        $sth->bindParam(':description', $model->description);


        if ($sth->execute() && $this->db->getDbh()->lastInsertId()) {
            $model->id = $this->db->getDbh()->lastInsertId();
            return true;
        }
        return false;
    }

    public function getAll()
    {
        $sql = 'select * from news';

        $sth = $this->db->getDbh()->prepare($sql);
        $sth->execute();
        $result = [];
        foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $item) {
            $result[$item['id']] = new NewsModel($item);
        }
        return $result;
    }

    public function getOne($id)
    {
        $sql = 'select * from news where id = :id';

        $sth = $this->db->getDbh()->prepare($sql);
        $sth->execute([
            ':id' => $id
        ]);
        return new NewsModel($sth->fetch(PDO::FETCH_ASSOC));
    }
}