<?php

namespace app\controllers;

use app\models\Tag;
use app\models\UploadForm;
use app\models\VideoTag;
use Faker\Provider\Image;
use Yii;
use app\models\VIdeo;
use app\models\VideoSearch;
use yii\base\Security;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * VideoController implements the CRUD actions for VIdeo model.
 */
class VideoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' =>['create','update','delete','index','view'],
                        'allow'=>true,
                        'roles'=>['@'],
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VIdeo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VIdeo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VIdeo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Video();
        $image = new \app\models\Image();
        $uploadForm = new UploadForm();
        $model->created = date('Y-m-d H:i:s');
        $model->updated = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $tags = explode(',', Yii::$app->request->post('tags'));

            if(count($tags)){
                foreach($tags as $tag) {
                    $foundTag =  Tag::find()->where(['name' => $tag])->one();
                    if($foundTag == null) {
                        $foundTag = new Tag();
                        $foundTag->name = $tag;
                        $foundTag->save();
                    }

                    $videoTagRelation = new VideoTag();
                    $videoTagRelation->video_id = $model->id;
                    $videoTagRelation->tag_id = $foundTag->id;
                    $videoTagRelation->save();
                }
            }

            $uploadForm->file = UploadedFile::getInstances($uploadForm, 'file');

            if ($uploadForm->file && $uploadForm->validate()) {

                foreach ($uploadForm->file as $file) {
                    $path = 'uploads/' . Yii::$app->getSecurity()->generateRandomString() .  '.' . $file->extension;
                    $file->saveAs($path);

                    $image = new \app\models\Image();
                    $image->path = $path;
                    $image->video_id = $model->id;
                    $image->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
                'upload' => $uploadForm
            ]);
        }

    }

    /**
     * Updates an existing VIdeo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $image = new \app\models\Image();
        $uploadForm = new UploadForm();

        $model->updated = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $tags = explode(',', Yii::$app->request->post('tags'));

            if(count($tags)){
                foreach($tags as $tag) {
                    $foundTag =  Tag::find()->where(['name' => $tag])->one();
                    if($foundTag == null) {
                        $foundTag = new Tag();
                        $foundTag->name = $tag;
                        $foundTag->save();
                    }

                    $videoTagRelation = new VideoTag();
                    $videoTagRelation->video_id = $model->id;
                    $videoTagRelation->tag_id = $foundTag->id;
                    $videoTagRelation->save();
                }
            }

            $uploadForm->file = UploadedFile::getInstances($uploadForm, 'file');

            if ($uploadForm->file && $uploadForm->validate()) {

                foreach ($uploadForm->file as $file) {
                    $path = 'uploads/' . Yii::$app->getSecurity()->generateRandomString() .  '.' . $file->extension;
                    $file->saveAs($path);

                    $image = new \app\models\Image();
                    $image->path = $path;
                    $image->video_id = $model->id;
                    $image->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
                'upload' => $uploadForm
            ]);
        }
    }

    /**
     * Deletes an existing VIdeo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VIdeo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VIdeo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VIdeo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
