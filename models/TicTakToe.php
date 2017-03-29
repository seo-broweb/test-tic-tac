<?php
/**
 * Created by PhpStorm.
 * User: bro
 * Date: 29.03.2017
 * Time: 13:00
 */


namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


//use yii\base\Model;

class TicTakToe
{

    /**
     * Пустое игровое поле(стол)
     */
    const DEFAULT_BOARD = [
        0 => [0 => false, 1 => false, 2 => false],
        1 => [0 => false, 1 => false, 2 => false],
        2 => [0 => false, 1 => false, 2 => false]
    ];
    /**
     * Символ, которым сервер делает ходы: 0 - нолик, 1 - крестик
     */
    const DEFAULT_SYMBOL = 0;
    private $idBoard;
    private $arrayBoard;
    private $session;

    /**
     * TicTakToe constructor.
     * Используем singleton - сохраняем id стола.
     */

    static public function startGame()
    {
        $session = Yii::$app->session;
        $session->open();
        /*if (empty($this->idBoard)) {
            $this->idBoard = session_id();
        }*/


        #Генерируем id стола для примера
        $json['id'] = MD5(time());
        $_SESSION['games'][$json['id']] = [
            'board' => self::DEFAULT_BOARD
        ];

        if (mt_rand(0, 1)) {
            self::moveServer($json['id']);
            $json['message'] = 'Первый ход выполнил сервер';
        }

        //r($_SESSION);
        return (json_encode($json));
    }

    static public function getBoardCondition($id)
    {
        Yii::$app->session->open();

        $json['board'] = $_SESSION['games'][$id]['board'];
        #инвертируем дефолтный символ
        $json['expectedSymbol'] = 1 - self::DEFAULT_SYMBOL;
        $json['closingTime'] = self::getFreeTime($id);
        return $json;
    }

    static public function getFreeTime($id)
    {
        Yii::$app->session->open();
        #Если первый ход в игре
        if (!isset($_SESSION['games'][$id]['timeLastMove'])) {
            $_SESSION['games'][$id]['timeLastMove'] = time();
        }

        return ($_SESSION['games'][$id]['timeLastMove'] + 60 - time());
    }

    static public function move($id, $x, $y)
    {
        Yii::$app->session->open();
        $board = $_SESSION['games'][$id]['board'];

        $json = [];

        if ($board[$x][$y] !== false) {
            $json['error'][] = 'Ошибка, в выбранной клетке уже сделан ход';
        }

        if (self::getFreeTime($id) < 0) {
            unset($_SESSION['games'][$id]);
            $json['error'][] = 'Закончилось время хода, победил сервер, стол удалён';
        }

        //var_dump(self::getFreeTime($id));
        r($json['error']);
        if (!empty($json['error'])) {
            return (json_encode($json));
        }

        $board[$x][$y] = (int)(1 - self::DEFAULT_SYMBOL);
        //$_SESSION['games'][$id]['board'] = $board;
        $_SESSION['games'][$id]['timeLastMove'] = time();
        $_SESSION['games'][$id]['symbolLastMove'] = 1 - self::DEFAULT_SYMBOL;
        $_SESSION['games'][$id]['board'] = $board;

        $countFreePlaces = self::getCountFreePlaces($board);
        if ($countFreePlaces == 0) {
            $json['message'] = 'Ура, вы завершили игру!';
        } else {
            $board = self::moveServer($id);
        }


        $jsonCondition = self::getBoardCondition($id);

        #Формируем итоговый ответ
        $json = array_merge($json, $jsonCondition);
        r($board);

        r(self::getCountFreePlaces($board));


        return $json;


    }


    static public function getCountFreePlaces($board)
    {
        $i = 0;
        foreach ($board as $x => $row) {
            foreach ($row as $value) {
                if ($value === false) $i++;
            }
        }

        return $i;
    }

    static public function moveServer($id)
    {
        $board = $_SESSION['games'][$id]['board'];
        #сервер делает ход рандомно
        $x1 = mt_rand(0, 2);
        $y1 = mt_rand(0, 2);
        $moved = false;

        #Выбираем свободную клетку
        $i = 0;
        while (!$moved && $i < 10) {
            #Если успешно сделали ход - выходим из цикла
            if ($board[$x1][$y1] === false) {
                $board[$x1][$y1] = self::DEFAULT_SYMBOL;
                $_SESSION['games'][$id]['timeLastMove'] = time();
                $_SESSION['games'][$id]['symbolLastMove'] = self::DEFAULT_SYMBOL;
                $_SESSION['games'][$id]['board'] = $board;
                $moved = true;
                break;
            }
            #Если в клетке уже есть ход
            if ($board[$x1][$y1] !== false) {
                #Если не выйдем за границы клетки при следующей проверке
                if ($y1 + 1 < 2) {
                    $y1++;
                } else {
                    $y1 = 0;
                    #Если выйдем, переходим на первую строку
                    if ($x1 + 1 > 2) {
                        $x1 = 0;
                    } else {
                        $x1++;

                    }

                }
            }

            $i++;

        }
        return $board;
    }


    /**
     * @return mixed
     */
    public function getIdBoard()
    {
        return $this->idBoard;
    }

}