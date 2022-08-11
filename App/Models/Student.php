<?php

namespace App\Models;

require(dirname(__DIR__) . '/Config.php');

use PDO;

class Student
{
    protected array $data;
    protected array $sort_list = array(
        'name_asc'   => '`name`',
        'name_desc'  => '`name` DESC',
        'surname_asc'  => '`surname`',
        'surname_desc' => '`surname` DESC',
        'group_asc'   => '`group`',
        'group_desc'  => '`group` DESC',
        'point_asc'   => '`point`',
        'point_desc'  => '`point` DESC',
        'gender_asc'   => '`gender`',
        'gender_desc'  => '`gender` DESC',
    );
    private $limitPosts = 50;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, DB_LOGIN, DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
    public function allStudent($sort, $page = null): array
    {
        /* Проверка GET-переменной */
        $sort = $_GET['sort'] ?? '';
        if (array_key_exists($sort, $this->sort_list)) {
            $sort_sql =  $this->sort_list[$sort];
        } else {
            $sort_sql = reset($this->sort_list);
        }
        $db = static::getDB();
        if (!empty($page)) {
            $from = ($page - 1) * $this->limitPosts;
            $stmt = $db->query("SELECT * FROM `list` WHERE id > 0 ORDER BY {$sort_sql} LIMIT $from,$this->limitPosts");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $db->query("SELECT * FROM `list` WHERE id > 0 ORDER BY {$sort_sql}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function pagination()
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT COUNT(*) as count FROM `list`");
        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pageCount = ceil($count[0]['count'] / $this->limitPosts);
        return $pageCount;
    }

    public function addStudent()
    {
        foreach ($this->data as $key => $field) {
            if ($this->checkNotEmpty($field) == false) {
                $_SESSION['errors'][$key] = 'Заполните пожалуйста все поля';
                break;
                return false;
            }
        }
        if ($this->checkEmail($this->data['email']) == false) {
            $_SESSION['errors']['email'] = 'Ваша почта не является корректной';
            return false;
        }
        if ($this->checkCyrillic($this->data['name']) == false) {
            $_SESSION['errors']['name'] = 'Имя должно быть только русскими буквами';
            return false;
        }
        if ($this->checkCyrillic($this->data['surname']) == false || $this->maxLength($this->data['surname']) == false) {
            $_SESSION['errors']['surname'] = 'Фамилия должна быть только русскими буквами меньше 200 символов';
            return false;
        }
        if ($this->checkGroup($this->data['group']) == false) {
            $_SESSION['errors']['group'] = 'Группа должна состоять из латинский Букв, Цифр от 2 до 5 символов';

            return false;
        }
        if ($this->checkPoints($this->data['points']) == false) {
            $_SESSION['errors']['points'] =  'Баллы должны быть целым числом от 0 до 100';
            return false;
        }
        $db = static::getDB();
        $stmt = $db->prepare("SELECT COUNT(*)AS count FROM `list` WHERE `surname`=:surname");
        $stmt->execute([':surname' => $this->data['surname']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result[0]['count'] > 0) {
            $_SESSION['errors']['surname'] = 'Пользователь с фамилии ' . $this->data['surname'] . ' уже существует ';
            return false;
        } else {
            $stmt = $db->prepare("INSERT INTO `list`(`name`, `surname`, `group`, `point`, `gender`, `email`) VALUES (:name,:surname,:group,:point,:gender,:email)");
            $stmt->execute([
                ':name' => $this->data['name'],
                ':surname' => $this->data['surname'],
                ':group' => $this->data['group'],
                ':point' => $this->data['points'],
                ':gender' => $this->data['gender'],
                ':email' => $this->data['email'],
            ]);

            $_SESSION['success'] = 'Студент успешно добавлен';
            return true;
        }
    }


    private function checkCyrillic(string $name): bool
    {
        if (preg_match('/^([а-яА-ЯЁё]+)$/u', $name)) {
            return true;
        } else {
            return false;
        }
    }
    private function checkEmail(string $email): bool
    {
        if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            return true;
        } else {
            return false;
        }
    }
    private function checkNotEmpty(string $field): bool
    {
        $field = trim($field);
        if (empty($field)) {
            return false;
        } else {
            return true;
        }
    }
    private function checkGroup(string $group): bool
    {
        if (preg_match('/\b[A-Z]{2,5}\b/', $group)) {
            return true;
        } else {
            return false;
        }
    }
    private function maxLength(string $string): bool
    {
        if (strlen(trim($string)) < 50) {
            return true;
        } else {
            return false;
        }
    }
    private function checkPoints(string $points): bool
    {
        if (is_numeric(trim($points)) && $points >= 0 &&  $points <= 100) {
            return true;
        } else {
            return false;
        }
    }
}
