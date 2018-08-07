<?php

namespace app\controllers;

use Yii;
use app\models\Penulis;
use app\models\PenulisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

/**
 * PenulisController implements the CRUD actions for Penulis model.
 */
class PenulisController extends Controller
{
    public $layout = 'main';
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
     * Lists all Penulis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenulisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penulis model.
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
     * Creates a new Penulis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penulis();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penulis model.
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
     * Deletes an existing Penulis model.
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
     * Finds the Penulis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penulis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penulis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDaftarPenulis()
    {
        $phpWord = new PhpWord();

        //Font Size untuk seluruh text
        $phpWord->setDefaultFontSize(11);

        //Font Style untk seluruh text
        $phpWord->setDefaultFontName('Gentium Basic');

        //Margin kertas
        $section = $phpWord->addSection([
            'marginTop' => Converter::cmToTwip(1.80),
            'marginBottom' => Converter::cmToTwip(1.30),
            'marginLeft' => Converter::cmToTwip(1.2),
            'marginRight' => Converter::cmToTwip(1.6),
        ]);
        
        $headerStyle = [
            'bold' => true,
        ];
        $paragraphCenter = [
            'alignment' => 'center',
            'spacing' => 0,
        ];
        $section->addText(
            'DAFTAR PENULIS BUKU',
            $headerStyle,
            $paragraphCenter
        );
        $section->addText(
            'PERPUSTAKAAN PPI',
            $headerStyle,
            $paragraphCenter
        );
        $section->addTextBreak(1);
        
        $table = $section->addTable([
            'alignment' => 'center', 
            'bgColor' => '000000',
            'borderSize' => 6,
        ]);
        $table->addRow(null);
        $table->addCell(500)->addText('NO', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('NAMA PENULIS', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('ALAMAT', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('TELEPON', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('EMAIL', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('JUMLAH BUKU', $headerStyle, $paragraphCenter);

        $semuaPenulis = Penulis::find()->all();
        $nomor = 1;
        foreach ($semuaPenulis as $penulis) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $paragraphCenter);
            $table->addCell(5000)->addText($penulis->nama, null);
            $table->addCell(5000)->addText($penulis->alamat, null);
            $table->addCell(5000)->addText($penulis->telepon, null);
            $table->addCell(5000)->addText($penulis->email, null);
            $table->addCell(5000)->addText($penulis->getJumlahBuku(), null, $paragraphCenter);
        }
        $filename = time() . 'Daftar-Penulis.docx';
        $lokasi = 'dokumen/' . $filename;
        $xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($lokasi);
        return $this->redirect($lokasi);
}
}
