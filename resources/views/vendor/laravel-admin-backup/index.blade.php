<script data-exec-on-popstate>
    $(function () {

        $(".backup-run").click(function() {
            var $btn = $(this);
            $btn.button('loading');

            NProgress.start();
            $.ajax({
                url: $btn.attr('href'),
                data : {
                    _token: LA.token
                },
                method: 'POST',
                success: function (data){

                    if (data.status) {
                        $('.output-box').removeClass('hide');
                        $('.output-box .output-body').html(data.message)
                    }

                    $btn.button('reset');
                    NProgress.done();
                }
            });

            return false;
        });

        $(".backup-delete").click(function() {

            var $btn = $(this);

            $.ajax({
                url: $btn.attr('href'),
                data : {
                    _token: LA.token
                },
                method: 'DELETE',
                success: function (data){

                    $.pjax.reload('#pjax-container');

                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }

                    $btn.button('reset');
                }
            });

            return false;
        });

    });
</script>

<style>
    .output-body {
        white-space: pre-wrap;
        background: #000000;
        color: #00fa4a;
        padding: 10px;
        border-radius: 0;
    }

    .todo-list>li .tools {
        display: none;
        float: none;
        color: #3c8dbc;
        margin-left: 10px;
    }

</style>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">备份记录</h3>

        <div class="box-tools">
            <a href="{{ route('backup-run') }}" class="btn btn-dropbox backup-run">备份</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
            <tr>
                <th>#</th>
                <th>名字</th>
                <th>驱动</th>
                <th>状态</th>
                <th>将康的</th>
                <th>#备份</th>
                <th>最新备份</th>
                <th>占用</th>
            </tr>
            @foreach($backups as $index => $backup)
                <tr data-toggle="collapse" data-target="#trace-{{$index+1}}" style="cursor: pointer;">
                    <td>{{ $index+1 }}.</td>
                    <td>{{ $backup[0] }}</td>
                    <td>{{ $backup[1] }}</td>
                    <td>{{ $backup[2] }}</td>
                    <td>{{ $backup[3] }}</td>
                    <td>{{ $backup['amount'] }}</td>
                    <td>{{ $backup['newest'] }}</td>
                    <td>{{ $backup['usedStorage'] }}</td>
                </tr>
                <tr class="collapse" id="trace-{{$index+1}}">
                    <td colspan="8">
                        <ul class="todo-list ui-sortable">
                            @foreach($backup['files'] as $file)
                                <li>
                                    <span class="text">{{ $file }}</span>
                                    <!-- Emphasis label -->

                                    <div class="tools">
                                        <a target="_blank" href="{{ route('backup-download', ['disk' => $backup[1], 'file' => $backup[0].'/'.$file]) }}"><i class="fa fa-download"></i></a>
                                        <a href="{{ route('backup-delete', ['disk' => $backup[1], 'file' => $backup[0].'/'.$file]) }}" class="backup-delete"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-default output-box hide">
    <div class="box-header with-border">
        <i class="fa fa-terminal"></i>

        <h3 class="box-title">输出</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <pre class="output-body"></pre>
    </div>
    <!-- /.box-body -->
</div>
