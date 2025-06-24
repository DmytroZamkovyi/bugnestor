<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timetracker;

/**
 * TimetrackerSearch represents the model behind the search form of `app\models\Timetracker`.
 */
class TimetrackerSearch extends Timetracker
{
    public $project_id;
    public $date_from;
    public $date_to;
    public $totalTime;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'project_id'], 'integer'],
            [['date', 'date_from', 'date_to', 'comment'], 'safe'],
            [['time', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Timetracker::find()->where(['user_id' => \Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'time' => $this->time,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }

    public function report($user_id, $project_id, $date_from, $date_to)
    {
        $query = Timetracker::find()
            ->joinWith(['user', 'task.project'])
            ->andFilterWhere(['user_id' => $user_id])
            ->andFilterWhere(['task.project_id' => $project_id])
            ->andFilterWhere(['between', 'date', $date_from, $date_to]);

        // Отримати загальний час як INTERVAL
        $cloneQuery = clone $query;
        $this->totalTime = $cloneQuery
            ->select(['sum_time' => new \yii\db\Expression("SUM(time) OVER()")])
            ->createCommand()
            ->queryScalar();

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
