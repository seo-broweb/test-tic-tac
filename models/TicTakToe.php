<?php
/**
 * Created by PhpStorm.
 * User: bro
 * Date: 29.03.2017
 * Time: 13:00
 */


namespace app\models;

use Yii;

//use yii\base\Model;

class TicTakToe
{
    /**
     * Пустое игровое поле(стол)
     */
    const DEFAULT_BOARD = [
        0 => ['', '', ''],
        1 => ['', '', ''],
        2 => ['', '', '']
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
    public function startGame()
    {
        $this->session = Yii::$app->session;
        $this->session->open();
        /*if (empty($this->idBoard)) {
            $this->idBoard = session_id();
        }*/
        if (!$this->session->has('idBoard')) {
            $this->session->set('idBoard', session_id());
            #Заполняем новый стол
            $this->session->set('arrayBoard', self::DEFAULT_BOARD);
        }

        $this->idBoard = $this->session->get('idBoard');

        $json['idBoard'] = $this->idBoard;


        return (json_encode($json));
    }

    public function getBoardCondition($id)
    {
        $json['arrayBoard'] = ($this->session->get('arrayBoard'));
        $json['expectedSymbol'] = 1 - self::DEFAULT_SYMBOL;
        $json['closingTime'] = '';

        return (json_encode($json));
    }

    public function move($id, $x, $y)
    {



    }

    /**
     * @return mixed
     */
    public function getIdBoard()
    {
        return $this->idBoard;
    }

}