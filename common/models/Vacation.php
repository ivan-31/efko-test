<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * модель Vacation (график отпусков)
 *
 * @property integer $id
 * @property integer $user_id
 * @property date $date_start
 * @property date $date_end
 * @property boolean $fixed
 */

class Vacation extends ActiveRecord
{

    /**
     * Имя таблицы
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vacation}}';
    }

    /**
     * Правила валидации сохраняемых данных
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end'], 'required'],
            [['date_start', 'date_end'], 'date', 'format' => 'php:Y-m-d', 'message' => 'Дата должна быть в формате ГГГГ-ММ-ДД'],
            ['date_start', 'compare', 'compareValue' => date('Y-m-d', time()), 'operator' => '>', 'message' => 'Дата начала отпуска должна быть в будущем.'],
            ['date_end', 'compare', 'compareAttribute' => 'date_start', 'operator' => '>', 'message' => 'Дата окончания отпуска должна быть позднее даты начала'],
            [['user_id', 'fixed', 'id'], 'integer'],
        ];
    }

    /**
     * Названия атрибутов
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'fixed' => 'Утвержден руководителем',
        ];
    }

    /**
     * Связь с моделью User
     * (Необходимо, чтобы взять оттуда ФИО)
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Получаем модель Vacation
     * в зависимости от роли и необходимого действия (insert|update)
     *
     * @return Vacation|null
     */
    public static function getModel()
    {
        if (Yii::$app->user->identity->role == 'manager') {
            $vacation = Yii::$app->request->post('Vacation');
            if (!is_numeric($vacation['id'])) return null;
            return self::findOne(['id' => (int) $vacation['id'], 'fixed' => 0]);
        } else {
            $existModel = self::findOne(['user_id' => Yii::$app->user->id]);
            return $existModel ?? new self();
        }
    }
}
