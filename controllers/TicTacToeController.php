<?php

namespace app\controllers;

use Yii;
use app\models\TicTakToe;

class TicTacToeController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $response = '';
        if (Yii::$app->request->post() ) {
            if (Yii::$app->request->post('startGame') ) {
                $response = TicTakToe::startGame();
            }

            if (Yii::$app->request->post('getBoardCondition') ) {
                $response = TicTakToe::getBoardCondition(Yii::$app->request->post('idBoard'));
            }

            if (Yii::$app->request->post('move') ) {
                //r(Yii::$app->request->post());
                $response = TicTakToe::move(Yii::$app->request->post('idBoard'), Yii::$app->request->post('x'),
                    Yii::$app->request->post('y'));
            }



        }


        return $this->render('index',['response' => $response]);
    }

    public function actionRequest(){
        //Для теста

        $id = '061974759993163476f5990b0ba91f22';
        //$ticTacToe = new TicTakToe();
        //TicTakToe::startGame();

        //TicTakToe::move($id,2,0);


    }

}
