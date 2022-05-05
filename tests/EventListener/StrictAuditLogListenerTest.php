<?php

namespace Landingi\EventStoreBundle\EventListener;

use Generator;
use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\AggregateName;
use Landingi\EventStoreBundle\Event\AggregateUuid;
use Landingi\EventStoreBundle\Event\EventData;
use Landingi\EventStoreBundle\Event\EventName;
use Landingi\EventStoreBundle\Event\UserUuid;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class StrictAuditLogListenerTest extends TestCase
{
    /**
     * @dataProvider auditLogEventsProvider
     */
    public function testItListensOnlyAuditLogEvents(string $eventName): void
    {
        $listener = new StrictAuditLogListener(
            $recorder = new InMemoryListener()
        );
        $listener->onEvent(
            $event = new Event(
                new EventName($eventName),
                new EventData(['foo' => 'bar']),
                new AggregateName('account'),
                new AggregateUuid(Uuid::v4()),
                new AccountUuid(Uuid::v4()),
                new UserUuid(Uuid::v4()),
            )
        );

        self::assertEquals(
            [$event],
            $recorder->getEvents()
        );
    }

    public function testItDoesNotListenOtherEvents(): void
    {
        $listener = new StrictAuditLogListener(
            $recorder = new InMemoryListener()
        );
        $listener->onEvent(
            new Event(
                new EventName('foobar'),
                new EventData(['foo' => 'bar']),
                new AggregateName('account'),
                new AggregateUuid(Uuid::v4()),
                new AccountUuid(Uuid::v4()),
                new UserUuid(Uuid::v4()),
            )
        );

        self::assertEmpty(
            $recorder->getEvents()
        );
    }

    public function auditLogEventsProvider(): Generator
    {
        yield ['variant_save'];
        yield ['variant_published'];
        yield ['variant_archive'];
        yield ['landing_add_variant'];
        yield ['landing_start_ab_test'];
        yield ['landing_edit_ab_test'];
        yield ['landing_stop_ab_test'];
        yield ['landing_select_winner_ab_test'];
        yield ['landing_archive'];
        yield ['landing_restore'];
        yield ['landing_create'];
        yield ['landing_download'];
        yield ['landing_duplicate'];
        yield ['landing_import'];
        yield ['landing_rename'];
        yield ['landing_unpublish'];
        yield ['landing_start_schedule'];
        yield ['landing_stop_schedule'];
        yield ['landing_reset_stats'];
        yield ['lead_edit'];
        yield ['add_javascript'];
        yield ['edit_javascript'];
        yield ['delete_javascript'];
        yield ['toggle_javascript'];
        yield ['popup_new_create'];
        yield ['popup_new_delete'];
        yield ['popup_new_rename'];
        yield ['popup_new_save'];
        yield ['popup_new_publish'];
        yield ['popup_new_unpublish'];
        yield ['popup_new_dashboard_publish'];
        yield ['popup_new_dashboard_unpublish'];
        yield ['popup_new_duplicate'];
        yield ['popup_new_lead_delete'];
        yield ['lightbox_create'];
        yield ['lightbox_rename'];
        yield ['lightbox_delete'];
        yield ['lightbox_duplicate'];
        yield ['lightbox_save'];
        yield ['account_billing_info_change'];
        yield ['account_cancel_subscription'];
        yield ['account_add_font'];
        yield ['account_delete_font'];
        yield ['account_export_lead'];
        yield ['account_archive_lead'];
        yield ['account_delete_lead'];
        yield ['account_delete_spamlead'];
        yield ['account_restore_lead'];
        yield ['account_enable_feature'];
        yield ['account_disable_feature'];
        yield ['account_create_token'];
        yield ['account_delete_token'];
        yield ['account_create_user'];
        yield ['account_delete_user'];
        yield ['account_add_domain'];
        yield ['account_domain_assign_landing'];
        yield ['account_delete_domain'];
        yield ['account_share_domain'];
        yield ['account_change_timezone'];
        yield ['account_change_package'];
        yield ['account_change_default_landing_language'];
        yield ['account_set_payment_gate_settings'];
        yield ['agency_edit_user'];
        yield ['agency_remove_user'];
        yield ['agency_give_user_access_to_subaccount'];
        yield ['agency_remove_user_access_to_subaccount'];
        yield ['agency_add_admin'];
        yield ['agency_edit_admin'];
        yield ['agency_delete_admin'];
        yield ['agency_add_subaccount'];
        yield ['agency_activate_subaccount'];
        yield ['agency_deactivate_subaccount'];
        yield ['agency_delete_subaccount'];
        yield ['agency_edit_subaccount'];
        yield ['agency_gallery_create_folder'];
        yield ['agency_gallery_rename_folder'];
        yield ['agency_gallery_delete_folder'];
        yield ['agency_gallery_delete_picture'];
        yield ['agency_gallery_upload_picture'];
        yield ['agency_gallery_moved_picture'];
        yield ['agency_create_template'];
        yield ['agency_restore_template'];
        yield ['agency_archive_template'];
        yield ['agency_duplicate_template'];
        yield ['agency_rename_template'];
        yield ['agency_save_template'];
        yield ['agency_duplicate_landing_to_sub_account'];
        yield ['change_user_email'];
        yield ['log_in'];
        yield ['published'];
        yield ['save'];
        yield ['sms_sent'];
        yield ['phone_verified'];
        yield ['landing_group_page_assigned'];
        yield ['landing_group_page_dismissed'];
        yield ['landing_move'];
        yield ['unsplash_image_import'];
        yield ['account_resource_limit_created'];
        yield ['account_resource_limit_edited'];
        yield ['account_resource_limit_deleted'];
        yield ['account_resource_limit_attached'];
        yield ['account_resource_limit_detached'];
    }
}
