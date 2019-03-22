<?php

return [
    'exception_message' => '异常消息:message',
    'exception_trace' => '异常跟踪: :trace',
    'exception_message_title' => '异常消息',
    'exception_trace_title' => '异常跟踪',

    'backup_failed_subject' => '备份失败 :application_name',
    'backup_failed_body' => 'Important: 备份时发生错误 :application_name',

    'backup_successful_subject' => '新备份成功 :application_name',
    'backup_successful_subject_title' => '成功的新备份!',
    'backup_successful_body' => '好消息，一个新的备份 :application_name 是否在名为:disk_name的磁盘上成功创建.',

    'cleanup_failed_subject' => '清理的备份 :application_name 失败的.',
    'cleanup_failed_body' => '清理备份时发生错误 :application_name',

    'cleanup_successful_subject' => '清理的 :application_name 备份成功',
    'cleanup_successful_subject_title' => '清理备份成功!',
    'cleanup_successful_body' => '成功清理了:disk_name上的 :application_name备份.',

    'healthy_backup_found_subject' => '磁盘上:application_name :disk_name的备份是健康的',
    'healthy_backup_found_subject_title' => 'application_name的备份是健康的',
    'healthy_backup_found_body' => 'application_name的备份被认为是健康的。好工作!',

    'unhealthy_backup_found_subject' => '重要提示::application_name的备份不健康',
    'unhealthy_backup_found_subject_title' => '重要提示::application_name的备份不健康。:problem',
    'unhealthy_backup_found_body' => '磁盘上:application_name:disk_name的备份不健康。',
    'unhealthy_backup_found_not_reachable' => '无法到达备份目的地。:error',
    'unhealthy_backup_found_empty' => '这个应用程序根本没有备份。',
    'unhealthy_backup_found_old' => ':date所做的最新备份被认为太旧了。',
    'unhealthy_backup_found_unknown' => '对不起，具体原因还不能确定。',
    'unhealthy_backup_found_full' => '备份使用了太多的存储空间。当前使用情况是:disk_usage，它高于:disk_limit的允许限制。',
];
