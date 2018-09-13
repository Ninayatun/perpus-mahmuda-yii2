<?php

namespace app\controllers;

use Yii;
use app\models\Buku;
use app\models\BukuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use PhpOffice\PhpWord\IOfactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\filters\AccessControl;
use app\models\User;


/**
 * BukuController implements the CRUD actions for Buku model.
 */
class BukuController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'create'],
                        'allow' => User::isAdmin() || User::isPetugas(),
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Buku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BukuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buku model.
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
     * Creates a new Buku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_kategori=null, $id_penulis=null, $id_penerbit=null)
    {
        $model = new Buku();

        $model->id_kategori = $id_kategori;
        $model->id_penulis = $id_penulis;
        $model->id_penerbit = $id_penerbit;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $sampul = UploadedFile::getInstance($model, 'sampul');
            $berkas = UploadedFile::getInstance($model, 'berkas');

            $model->sampul = time() . '_' . $sampul->name;
            $model->berkas = time() . '_' . $berkas->name;

            $model->save(false);

            $sampul->saveAs(Yii::$app->basePath . '/web/upload/sampul/' . $model->sampul);
            $berkas->saveAs(Yii::$app->basePath . '/web/upload/berkas/' . $model->berkas);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Buku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
        public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Mengambi data lama di databases
        $sampul_lama = $model->sampul;
        $berkas_lama = $model->berkas;
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            
            // Mengambil data baru di layout _from
            $sampul = UploadedFile::getInstance($model, 'sampul');
            $berkas = UploadedFile::getInstance($model, 'berkas');
            // Jika ada data file yang dirubah maka data lama akan di hapus dan di ganti dengan data baru yang sudah diambil jika tidak ada data yang dirubah maka file akan langsung save data-data yang lama.
            if ($sampul !== null) {
                unlink(Yii::$app->basePath . '/web/upload/sampul' . $sampul_lama);
                $model->sampul = time() . '_' . $sampul->name;
                $sampul->saveAs(Yii::$app->basePath . '/web/upload/sampul' . $model->sampul);
            } else {
                $model->sampul = $sampul_lama;
            }
            if ($berkas !== null) {
                unlink(Yii::$app->basePath . '/web/upload/berkas' . $berkas_lama);
                $model->berkas = time() . '_' . $berkas->name;
                $berkas->saveAs(Yii::$app->basePath . '/web/upload/berkas' . $model->berkas);
            } else {
                $model->berkas = $berkas_lama;
            }
            // Simapan data ke databases
            $model->save(false);
            // Menuju ke view id yang data dibuat.
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Buku model.
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
     * Finds the Buku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buku::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExportWord()
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => Converter::cmToTwip(1.80),
            'marginBottom' => Converter::cmToTwip(1.30),
            'marginLeft' => Converter::cmToTwip(1.2),
            'marginRight' => Converter::cmToTwip(1.6),
        ]);
        
        $fontStyle = [
            'underline' => 'dash',
            'bold' => 'true',
            'italic' => 'true',
        ];

        $paragraphCenter = [
            'alignment' => 'center',
        ];

        $section->addText(
            'Jadwal Pengadaan Langsung',
            $fontStyle,
            $paragraphCenter
        );

        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Pengadaan jasa', $fontStyle);
        $judul->addText(' Konsultasi', ['italic' => true]);
        $judul->addText(' Sistem Informasi', ['bold' => true]);

        // $section->addText(
        //     'teks 1 2 3',
        //     ['bold' => true],
        //     ['alignment' => 'center']
        // );

        // $semuaBuku = Buku::find()->all();
        // foreach ($semuaBuku as $buku) {
        //     $section->addText($buku->nama);
        // }

        /*
        $section->addListItem('List Item I', 0);
        $section->addListItem('List Item I.a', 1);
        $section->addListItem('List Item I.b', 1);
        $section->addListItem('List Item II', 0);
        */

        $filename = time() . 'document-buku.docx';
        $path = 'dokumen/' . $filename;
        $xmlWriter = IOfactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($path);
        return $this->redirect($path);
    }

    public function actionJadwalPl()
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
            'JADWAL PENGADAAN LANGSUNG',
            $headerStyle,
            $paragraphCenter
        );
        $section->addText(
            'PENGADAAN JASA KONSULTASI',
            $headerStyle,
            $paragraphCenter
        );
        $section->addTextBreak(1);
        $section->addText(
            'PEJABAT PENGADAAN BARANG/JASA',
            $headerStyle,
            [
                'alignment' => 'left'
            ]
        );
        $section->addText(
            'SATKER 450417 LAN JAKARTA',
            $headerStyle,
            [
                'alignment' => 'left'
            ]
        );
        $section->addTextBreak(1);
        $section->addText(
            'PEKERJAAN PEMBANGUNAN SISTEM INFORMASI PENGADAAN (SIP) KANTOR LAN JAKARTA ',
            $headerStyle,
            $paragraphCenter
        );
        $section->addTextBreak(1);
        $section->addText(
            'PAGU DANA  :   Rp. 12.000.000,-',
            $headerStyle,
            [
                'alignment' => 'left'
            ]
        );
        $section->addText(
            'HPS       : Rp. 11.000.000,- ',
            $headerStyle,
            [
                'alignment' => 'left'
            ]
        );
        $table = $section->addTable([
            'alignment' => 'center', 
            'bgColor' => '000000',
            'borderSize' => 6,
        ]);
         
        $table->addRow(null);
        $table->addCell(500)->addText('NO', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('JUDUL BUKU', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('TAHUN TERBIT', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('PENULIS', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('PENERBIT', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('KATEGORI', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('SAMPUL', $headerStyle, $paragraphCenter);

        $semuaBuku = Buku::find()->all();
        $nomor = 1;
        foreach ($semuaBuku as $buku) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $paragraphCenter);
            $table->addCell(5000)->addText($buku->nama, null);
            $table->addCell(5000)->addText($buku->tahun_terbit, null, $paragraphCenter);
            $table->addCell(5000)->addText($buku->penulis->nama, null, $paragraphCenter);
            $table->addCell(5000)->addText($buku->penerbit->nama, null, $paragraphCenter);
            $table->addCell(5000)->addText($buku->kategori->nama, null, $paragraphCenter);
            $table->addCell(5000)->addText(Yii::$app->request->baseUrl.'/upload/sampul/'.$buku['sampul'], null, $paragraphCenter);
        }
        


        $filename = time() . 'Jadwal-PL.docx';
        $lokasi = 'dokumen/' . $filename;
        $xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($lokasi);
        return $this->redirect($lokasi);
    }

    public function actionExportPdf()
   {
         $this->layout='main1';
         $model = Buku::find()->All();
         $mpdf=new mPDF();
         $mpdf->WriteHTML($this->renderPartial('template',['model'=>$model]));
         $mpdf->Output('DataBuku.pdf', 'D');
         exit;
   }

   public function actionExportExcel() {
     
    $spreadsheet = new PhpSpreadsheet\Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();
     
    //Menggunakan Model

    $database = Buku::find()
    ->select('nama, tahun_terbit')
    ->all();

    $worksheet->setCellValue('A1', 'Judul Buku');
    $worksheet->setCellValue('B1', 'Tahun Terbit');
     
    //JIka menggunakan DAO , gunakan QueryAll()
     
    /*
     
    $sql = "select kode_jafung,jenis_jafung from ref_jafung"
     
    $database = Yii::$app->db->createCommand($sql)->queryAll();
     
    */
     
    $database = \yii\helpers\ArrayHelper::toArray($database);
    $worksheet->fromArray($database, null, 'A2');
     
    $writer = new Xlsx($spreadsheet);
     
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="download.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
     
    }

    // public function actionSuratCerai()
    // {
    //     $phpWord = new PhpWord();

    //     //Font Size untuk seluruh text
    //     $phpWord->setDefaultFontSize(11);

    //     //Font Style untk seluruh text
    //     $phpWord->setDefaultFontName('Bookman Old Style');

    //     //Margin kertas
    //     $section = $phpWord->addSection([
    //         'marginTop' => Converter::cmToTwip(1.80),
    //         'marginBottom' => Converter::cmToTwip(1.30),
    //         'marginLeft' => Converter::cmToTwip(1.2),
    //         'marginRight' => Converter::cmToTwip(1.6),
    //     ]);
        
    //     $headerStyle = [
    //         'bold' => true,
    //     ];
    //     // $underlineStyle = [
    //     //     'underline' => 'single',
    //     // ];
    //     $paragraphCenter = [
    //         'alignment' => 'center',
    //         'spacing' => 0,
    //     ];

    //     $section->addText(
    //         'PEMERINTAH KABUPATEN MUNA',
    //         $headerStyle,
    //         $paragraphCenter
    //     );
    //     $section->addText(
    //         'PEMERINTAH KECAMATAN BATA LAIWORU',
    //         $headerStyle,
    //         $paragraphCenter
    //     );
    //     $section->addText(
    //         'KANTOR LURAH LAIWORU',
    //         $headerStyle,
    //         $paragraphCenter
    //     );

    //     $section->addShape(
    //                'line',
    //                array(
    //                    'points'  => '1,1 380,0',
    //                    'outline' => array(
    //                        'color'      => '#000000',
    //                        'line'       => 'thickThin',
    //                        'weight'     => 1,
    //                    ),
    //                )
    //            );

    //     $section->addTextBreak(1);
    //     $section->addTextBreak(1);
    //     $section->addText(
    //         'SURAT KETERANGAN',
    //         [
    //             'underline' => 'single',
    //             'bold' => true,
    //         ],
    //         $paragraphCenter
    //     );
    //     $section->addText(
    //         'NO.',
    //         ['null'],
    //         $paragraphCenter
    //     );
    //     $section->addTextBreak(1);
    //     $section->addText(
    //         'Lurah laiworu menerangkan bahwa :',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //    $section->addText(
    //         'Nama:',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //    $section->addText(
    //         'Nip : 19621231 1983102 032',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //    $section->addText(
    //         'Umur : 51 Tahun',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //    $section->addText(
    //         'Pekerjaan : PNS',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //    $section->addText(
    //         'Alamat : Jl. Madesabara',
    //         [
    //             'alignment' => 'left'
    //         ]
    //     );
    //     $section->addTextBreak(1);
    //     $section->addText(
    //         'Adalah benar-benar memiliki seorang suami An. Alimin Kada Namun, '
    //     );

    //     $filename = time() . 'Surat-Cerai.docx';
    //     $lokasi = 'dokumen/' . $filename;
    //     $xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
    //     $xmlWriter->save($lokasi);
    //     return $this->redirect($lokasi);
    // }

    public function actionSuratCerai2()
    {
        $phpWord = new PhpWord();

        //Font Size untuk seluruh text
        $phpWord->setDefaultFontSize(11);

        //Font Style untk seluruh text
        $phpWord->setDefaultFontName('Bookman Old Style');
        $phpWord->setDefaultParagraphStyle(
        array(
            'align'      => 'both',
            'spaceAfter' => Converter::pointToTwip(0.7),
            'spacing'    => 0,
            )
        );
        $sectionStyle = [
            'marginTop'=>Converter::cmToTwip(2.25),
            'marginBottom'=>Converter::cmToTwip(2.49),
            'marginLeft'=>Converter::cmToTwip(2.2),
            'marginRight'=>Converter::cmToTwip(2.6),
        ];
        $paragraphCenter = [
            'alignment' => 'center',
            'spacing' => 0,
        ];
        $fontStyle = [
            'underline' => 'dash',
            'bold' => 'true',
            'italic' => 'true',
        ];
        $section = $phpWord->addSection($sectionStyle);
        $phpWord->addParagraphStyle('headerPStyle', ['alignment'=>'center']);
        $phpWord->addParagraphStyle('headerPStyleNoSpace', ['alignment'=>'center']);
        $phpWord->addFontStyle('headerFStyle', ['bold'=>true]);
        $phpWord->addParagraphStyle(
            'multipleTabLeft',
            array(
                'tabs' => array(
                    new \PhpOffice\PhpWord\Style\Tab('left', 750),
                    new \PhpOffice\PhpWord\Style\Tab('left', 1050),
                ),
                'align'=>'left'
            )
        );
        $phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'upperRoman', 'text' => '%1.', 'left' => 400, 'hanging' => 360, 'tabPos' => 360),
                    array('format' => 'decimal', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
                )
            )
        );
        //START HEADER
        $header_style = ['bold' => true, 'size' => 11];
        $header_page = $section->addHeader();
        $imageStyle = array(
            'width' => 70,
            'height' => 50,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        );
        //START OF HEADER
        $textrun = $header_page->addTextRun('headerPStyle');
        $textrun->addImage('images/Muna.png', $imageStyle);
        $textrun->addText("\t PEMERINTAH KABUPATEN MUNA", $header_style,'headerPStyle');
        $header_page->addText("\t PEMERINTAH KECAMATAN BATA LAIWORU", $header_style, 'headerPStyle');
        $header_page->addText("\t KANTOR LURAH LAIWORU", $header_style, 'headerPStyle');
        $textrun = $header_page->addTextRun('headerPStyle');
        // Line
        $header_page->addShape(
            'line',
            array(
                'points'  => '1,1 630,0',
                'outline' => array(
                    'color'      => '#000000',
                    'line'       => 'thickThin',
                    'weight'     => 2,
                ),
            )
        );

        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addText(
            'SURAT KETERANGAN',
            [
                'underline' => 'single',
                'bold' => true,
            ],
            $paragraphCenter
        );
        $section->addText(
            "NO. \t\t\t",
            ['null'],
            $paragraphCenter
        );
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addText(
            'Lurah laiworu menerangkan bahwa :',
            [
                'alignment' => 'left'
            ]
        );
        $nama = $section->addTextRun();
        $nama->addText("Nama \t\t\t\t :");
        $nama->addText(' WA ODE HALIDJAH', ['bold' => true]);
        $section->addText(
            "Nip \t\t\t\t : 19621231 1983102 032",
            [
                'alignment' => 'left'
            ]
        );
        $section->addText(
            "Umur \t\t\t\t : 51 Tahun",
            [
                'alignment' => 'left'
            ]
        );
        $section->addText(
            "Pekerjaan \t\t\t : PNS",
            [
                'alignment' => 'left'
            ]
        );
        $section->addText(
            "Alamat \t\t\t : Jl. Madesabara",
            [
                'alignment' => 'left'
            ]
        );
        $section->addTextBreak(1);
        $section->addText(
            'Adalah benar-benar memiliki seorang suami An. Alimin Kada Namun, sejak 12 tahun lalu sampai dengan saat ini mereka telah berpisah dan tidak serumah lagi.'
        );
        $section->addTextBreak(1);
        $section->addText(
            'Demikian surat keterangan ini, kami berikan untuk digunakan sebagaimana mestinya.'
        );
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addText(
            "\t\t\t\t\t\t\t\t Laiworu, 18-06-2013"
        );
        $section->addText(
            "\t\t\t\t\t\t\t\t LURAH LAIWORU"
        );
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $tertanda = $section->addTextRun();
        $tertanda->addText("\t\t\t\t\t\t\t");
        $tertanda->addText('ADI JAYA PURNAMA,S.STP,M.Si', ['underline' => 'single', 'bold' => true]);
        $section->addText(
            "\t\t\t\t\t\t\t NIP. 19830822 200212 1001"
        );

        $filename = time() . 'Surat-Cerai2.docx';
        $lokasi = 'dokumen/' . $filename;
        $xmlWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($lokasi);
        return $this->redirect($lokasi);
    }
}
