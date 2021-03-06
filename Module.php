<?php

namespace humhub\modules\announcements;

use humhub\modules\announcements\models\Announcement;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;
use Yii;
use yii\helpers\Url;

/**
 *
 * This class is also used to process events catched by the autostart.php listeners.
 *
 * @author David Born ([staxDB](https://github.com/staxDB))
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
            Space::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        foreach (Announcement::find()->all() as $announcement) {
            $announcement->delete();
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
        if ($contentContainer instanceof Space) {
            return [
                new permissions\CreateAnnouncement(),
                new permissions\ViewStatistics(),
                new permissions\MoveContent()
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

//    public function getContentContainerConfigUrl(ContentContainerActiveRecord $container)
//    {
//        return $container->createUrl('/announcement/container-config');
//    }

    public function getConfigUrl()
    {
        return Url::to([
            '/announcements/config'
        ]);
    }

}
