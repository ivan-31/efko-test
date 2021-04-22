<?php
// Провайдер данных для построения GridView в Vacation

namespace common\models;
use Yii;
use yii\data\ActiveDataProvider;

class VacationDataProvider
{
    const PAGE_SIZE = 10;

    public static function getDataProvider()
    {
        $userId = Yii::$app->user->identity->getId();

        $query = Vacation::find()
            ->joinWith('user')
            ->where('user_id <> :this_user', ['this_user' => $userId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        // добавляем сортировку по колонке из зависимости
        $dataProvider->sort->attributes['user.full_name'] = [
            'asc' => ['user.full_name' => SORT_ASC],
            'desc' => ['user.full_name' => SORT_DESC],
        ];

        // сортировка по умолчанию
        $dataProvider->sort->defaultOrder = [
            'fixed' => SORT_ASC,
            'date_start' => SORT_ASC,
        ];

        return $dataProvider;
    }

}