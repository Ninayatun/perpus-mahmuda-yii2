<?php

namespace app\controllers;

use Yii;
use app\models\Kategori;
use app\models\KategoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * KategoriController implements the CRUD actions for Kategori model.
 */
class KategoriController extends Controller
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
     * Lists all Kategori models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KategoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kategori model.
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
     * Creates a new Kategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kategori();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kategori model.
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
     * Deletes an existing Kategori model.
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
     * Finds the Kategori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kategori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kategori::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDaftarKategori()
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
            'DAFTAR KATEGORI BUKU',
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
        $table->addCell(5000)->addText('NAMA KATEGORI', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('JUMLAH BUKU', $headerStyle, $paragraphCenter);

        $semuaKategori = Kategori::find()->all();
        $nomor = 1;
        foreach ($semuaKategori as $kategori) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $paragraphCenter);
            $table->addCell(5000)->addText($kategori->nama, null);
            $table->addCell(5000)->addText($kategori->getJumlahBuku(), null, $paragraphCenter);
        }
        $filename = time() . 'Daftar-Kategori.docx';
        $lokasi = 'dokumen/' . $filename;
        $xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($lokasi);
        return $this->redirect($lokasi);
}

    public function actionExportPdf()
    {
         $this->layout='mainPdf';
         $model = Kategori::find()->All();
         $mpdf=new mPDF();
         $mpdf->WriteHTML($this->renderPartial('template',['model'=>$model]));
         $mpdf->Output('DataKategori.pdf', 'D');
         exit;
    }

    public function actionExportExcel() {
     
    $spreadsheet = new PhpSpreadsheet\Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
     
    //Menggunakan Model

    $database = Kategori::find()
    ->select('nama')
    ->all();

    $worksheet->setCellValue('A1', 'Nama');
     
    //JIka menggunakan DAO , gunakan QueryAll()
     
    /*
     
    $sql = "select kode_jafung,jenis_jafung from ref_jafung"
     
    $database = Yii::$app->db->createCommand($sql)->queryAll();
     
    */
     
    $database = \yii\helpers\ArrayHelper::toArray($database);
    $worksheet->fromArray($database, null, 'A2');
     
    $writer = new Xlsx($spreadsheet);
     
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="kategori.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
     
    }
}
