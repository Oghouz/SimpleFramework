<?php

namespace Core\DB;

use \PDOStatement;

class Sql
{
	protected $table;

	protected $primary = 'id';

	private $filter = '';

	private $param = [];

	public function where($where = [], $param = []) 
	{
		if ($where) {
			$this->filter .= ' WHERE ';
			$this->filter .= implode(' ', $where);
			$this->param = $param;
		}

		return $this;
	}

	public function order($order = [])
	{
		if ($order) {
			$this->filter .= ' ORDER BY ';
			$this->filter .= implode(',', $order);
		}
		return $this;
	}

	public function fetchAll()
	{
		$sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);
		$sth = DB::pdo()->prepare($sql);
		$sth = $this->formatParam($sth, $this->param);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function fetch()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);
        $sth = DB::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->fetch();
    }

    public function delete($id)
    {
        $sql = sprintf("DELETE FROM `%s` WHERE `%s` = :%s", $this->table, $this->primary, $this->primary);
        $sth = DB::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$this->primary => $id]);
        $sth->execute();

        return $sth->rowCount();
    }

    public function add($data)
    {
        $sql = sprintf("INSERT INTO `%s` %s", $this->table, $this->formatInsert($data));
        $sth = DB::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->rowCount();
    }

    public function update($data)
    {
        $sql = sprintf("UPDATE `%s` set %s %s", $this->table, $this->formatUpdate($data), $this->filter);
        $sth = DB::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->rowCount();
        
    }

    public function formatParam(PDOStatement $sth, $params = [])
    {
        foreach ($params as $param => $value)
        {
            $param = is_int($param) ? $param + 1 : ':' . ltrim($param, ':');
            $sth->bindParam($param, $value);
        }
        return $sth;
	}

    public function formatInsert($data)
    {
        $fields = [];
        $names = [];
        foreach ($data as $key => $value)
        {
            $fields[] = sprintf("`%s`", $key);
            $names[] = sprintf(":%s", $key);
        }

        $field = implode(',', $fields);
        $name = implode(',', $names);

        return sprintf("(%s) VALUES (%s)", $field, $name);
	}

    public function formatUpdate($data)
    {
        $fields = [];
        foreach ($data as $key => $value)
        {
            $fields[] = sprintf("`%s` = :%s", $key, $key);
        }

        return implode(',', $fields);
	}

}