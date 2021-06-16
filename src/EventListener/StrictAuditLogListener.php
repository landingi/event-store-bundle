<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventListener;

final class StrictAuditLogListener implements EventListener
{
    private const AUDITLOG_EVENTS = [
        'variant_save',
        'variant_published',
        'variant_archive',
        'landing_add_variant',
        'landing_start_ab_test',
        'landing_edit_ab_test',
        'landing_stop_ab_test',
        'landing_select_winner_ab_test',
        'landing_archive',
        'landing_restore',
        'landing_create',
        'landing_download',
        'landing_duplicate',
        'landing_import',
        'landing_rename',
        'landing_unpublish',
        'landing_start_schedule',
        'landing_stop_schedule',
        'landing_reset_stats',
        'lead_edit',
        'add_javascript',
        'edit_javascript',
        'delete_javascript',
        'toggle_javascript',
        'popup_new_create',
        'popup_new_delete',
        'popup_new_rename',
        'popup_new_save',
        'popup_new_publish',
        'popup_new_unpublish',
        'popup_new_dashboard_publish',
        'popup_new_dashboard_unpublish',
        'popup_new_duplicate',
        'popup_new_lead_delete',
        'lightbox_create',
        'lightbox_rename',
        'lightbox_delete',
        'lightbox_duplicate',
        'lightbox_save',
        'account_billing_info_change',
        'account_cancel_subscription',
        'account_add_font',
        'account_delete_font',
        'account_export_lead',
        'account_archive_lead',
        'account_delete_lead',
        'account_restore_lead',
        'account_enable_feature',
        'account_disable_feature',
        'account_create_token',
        'account_delete_token',
        'account_create_user',
        'account_delete_user',
        'account_add_domain',
        'account_domain_assign_landing',
        'account_delete_domain',
        'account_share_domain',
        'account_change_timezone',
        'account_change_package',
        'account_change_default_landing_language',
        'agency_edit_user',
        'agency_remove_user',
        'agency_give_user_access_to_subaccount',
        'agency_remove_user_access_to_subaccount',
        'agency_add_admin',
        'agency_edit_admin',
        'agency_delete_admin',
        'agency_add_subaccount',
        'agency_activate_subaccount',
        'agency_deactivate_subaccount',
        'agency_delete_subaccount',
        'agency_edit_subaccount',
        'agency_gallery_create_folder',
        'agency_gallery_rename_folder',
        'agency_gallery_delete_folder',
        'agency_gallery_delete_picture',
        'agency_gallery_upload_picture',
        'agency_gallery_moved_picture',
        'agency_create_template',
        'agency_restore_template',
        'agency_archive_template',
        'agency_duplicate_template',
        'agency_rename_template',
        'agency_save_template',
        'agency_duplicate_landing_to_sub_account',
        'change_user_email',
        'log_in',
        'published',
        'save',
        'sms_sent',
        'phone_verified',
        'landing_group_page_assigned',
        'landing_group_page_dismissed',
        'landing_move',
        'unsplash_image_import',
        'account_resource_limit_created',
        'account_resource_limit_edited',
        'account_resource_limit_deleted',
        'account_resource_limit_attached',
        'account_resource_limit_detached',
    ];

    private EventListener $eventListener;

    public function __construct(EventListener $eventListener)
    {
        $this->eventListener = $eventListener;
    }

    public function onEvent(Event $event): void
    {
        if (in_array((string) $event, self::AUDITLOG_EVENTS, true)) {
            $this->eventListener->onEvent($event);
        }
    }
}
