<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPdf()
    {

         $mpdf  = new mPDF();
         $mpdf->WriteHTML($this->renderPartial('pdfSurat'));
         $mpdf->Output('Formulir-Permohonan-KK.pdf', 'D');
         exit;

        $content = $this->renderPartial('pdfSurat');

        $marginLeft = 20;
        $marginRight = 15;
        $marginTop = 5;
        $marginBottom = 5;
        $marginHeader = 5;
        $marginFooter = 5;

        $cssInline = <<<CSS
                table {
                    overflow: wrap;
                    font-size: 8pt;
                }

                tr, td {
                    padding: 0px;
                }

                div {
                    overflow: wrap;
                }

                .konten div {
                    box-shadow:
                            2px 0 0 0 #888,
                            0 2px 0 0 #888,
                            2px 2px 0 0 #888,   /* Just to fix the corner */
                            2px 0 0 0 #888 inset,
                            0 2px 0 0 #888 inset;
                }

                .clear {
                    clear: both;
                }

                .kode {
                    border: 1px solid black;
                    float: right;
                    font-size: 15px;
                    font-weight: bold;
                    padding: 0px 10px;
                    height: 35px;
                    line-height: 35px;
                    text-align: center;
                    width: 17%;
                }

                .header {
                    font-size: 8pt;
                    overflow: hidden;
                }

                .header .left {
                    width: 60%;
                    float: left;
                }

                .header .right {
                    width: 40%;
                    float: left;
                }

                .header table {
                    border-spacing: 0px;
                    border-collapse: collapse;
                }

                .header table .caption {
                    width: 45%;
                }

                .header table .point {
                    width: 2%;
                }

                .header table .kotak {
                    width: 5%;
                }

                .kode span {
                    display: inline-block;
                    vertical-align: middle;
                    line-height: normal;
                }

                .debug, .debug tr, .debug td {
                    border: 1px solid black;
                }

                .kotak, .form {
                    border-spacing: 0px;
                    border-collapse: collapse;
                }

                .kotak {
                    border: 1px solid black;
                    height: 15px;
                    width: 2.87%;
                    text-align: center;
                }

                .colspan {
                    padding-left: 2px;
                    text-align: left;
                }

                .kanan {
                    width: 1%;
                }

                .t-center {
                    text-align: center;
                }

                h4 {
                    font-weight: bold;
                    font-family: Arial;
                    font-size: 12pt;
                }

                .form .caption {
                    width: 26.8%;
                }

                .form .point, .section .point {
                    width: 1%;
                }

                .section {
                    border: 2px solid black;
                    padding: 0px;
                    margin: -1px !important;
                }

                .section h5 {
                    margin: 0px;
                    font-weight: bold;
                    text-align: left;
                    font-size: 11px;
                }

                .section table {
                    border-spacing: 0px;
                    border-collapse: collapse;
                }

                .section .nomor {
                    width: 3%;
                }

                .section .caption {
                    width: 24%;
                }

                .section .isi {
                    float: left;
                    overflow: hidden;
                    display: inline-block;
                }

                .border {
                    border: 1px solid black;
                }

                .ttd-left {
                    width: 30%;
                    text-align: center;
                }

                .ttd-middle {
                    width: 40%;
                    text-align: center;
                }

                .ttd-right {
                    width: 30%;
                    text-align: center;
                }

CSS;

        $pdf = new Mpdf([
            'mode' => Mpdf::MODE_UTF8,
            // F4 paper format
            'format' => [210, 330],
            // portrait orientation
            'orientation' => Mpdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Mpdf::DEST_BROWSER,
            // your html content input

            'marginLeft' => $marginLeft,
            'marginRight' => $marginRight,
            'marginTop' => $marginTop,
            'marginBottom' => $marginBottom,
            'marginHeader' => $marginHeader,
            'marginFooter' => $marginFooter,

            'content' => $content,

            // format content from your own css file if needed or use the
            // any css to be embedded if required
            'cssInline' => $cssInline,
             // set mPDF properties on the fly
            'options' => ['title' => 'PDF Surat'],
             // call mPDF methods on the fly
            'methods' => []
        ]);

        return $pdf->render();
    }
}
