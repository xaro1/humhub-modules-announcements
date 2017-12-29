<?php

namespace humhub\modules\announcements;

use Yii;
use humhub\modules\announcements\models\Announcement;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;
use humhub\modules\space\models\Membership;

/**
 *
 * This class is also used to process events catched by the autostart.php listeners.
 *
 * @author davidborn
 */
class Module extends ContentContainerModule
{

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            Space::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (Announcement::find()->all() as $message) {
            $message->delete();
        }

        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        parent::disableContentContainer($container);

        foreach (Announcement::find()->contentContainer($container)->all() as $announcement) {
            $announcement->delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof \humhub\modules\space\models\Space) {
            return [
                new permissions\CreateAnnouncement(),
                new permissions\ViewStatistics()
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return Yii::t('AnnouncementsModule.base', 'Announcements');
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        return Yii::t('AnnouncementsModule.base', 'Allows to post messages to spaces, that can be confirmed as read.');
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('AnnouncementsModule.base', 'Announcements');
    }

    public function getDescription()
    {
        return Yii::t('AnnouncementsModule.base', 'Allows to post messages to spaces, that can be confirmed as read.');
    }


}