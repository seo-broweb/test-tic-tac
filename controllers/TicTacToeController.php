<?php

namespace app\controllers;

use app\models\TicTakToe;

class TicTacToeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRequest(){
        $ticTacToe = new TicTakToe();

        $ticTacToe->getBoardCondition($ticTacToe->getIdBoard());

    }

}
