<?php

namespace app\controllers;

use app\models\Timetracker;
use app\models\TimetrackerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimetrackerController implements the CRUD actions for Timetracker model.
 */
class TimetrackerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Timetracker models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TimetrackerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Timetracker model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Timetracker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($task_id)
    {
        $model = new Timetracker();

        if ($model->isNewRecord && empty($model->date)) {
            $model->date = date('Y-m-d');
        }

        $model->task_id = $task_id;
        $model->user_id = \Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Timetracker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Timetracker model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Timetracker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Timetracker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timetracker::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionReport($user_id = null, $project_id = null, $date_from = null, $date_to = null)
    {
        $searchModel = new TimetrackerSearch();
        $dataProvider = $searchModel->report($user_id, $project_id, $date_from, $date_to);

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_id' => $user_id,
            'project_id' => $project_id,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ]);
    }

    public function actionReportPdf($user_id = null, $project_id = null, $date_from = null, $date_to = null)
    {
        $searchModel = new TimetrackerSearch();
        $dataProvider = $searchModel->report($user_id, $project_id, $date_from, $date_to);

        $content = $this->renderPartial('_report_pdf', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'user_id' => $user_id,
            'project_id' => $project_id,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($content);
        return $mpdf->Output('report.pdf', \Mpdf\Output\Destination::INLINE); // або DOWNLOAD
    }
}
