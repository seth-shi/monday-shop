@extends('layouts.user')


@section('style')
    <link href="/assets/user/css/score_personal.css" rel="stylesheet" type="text/css">
@endsection

@section('main')
    <div class="main-wrap">
        <div class="points">
            <!--标题 -->
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">我的积分</strong> / <small>My&nbsp;Point</small></div>
            </div>
            <hr/>
            <div class="pointsTitle">
                <div class="usable">总积分<span>{{ $user->score_all }}</span></div>
                <div class="signIn"><i class="am-icon-calendar">可用积分: {{ $user->score_now }} </i></div>
            </div>
            <div class="pointlist" style="padding: 0px 10px;">
                <div class="pointTitle">
                    <span>积分规则</span>
                </div>
                @foreach ($rules as $rule)
                    <div style="padding-top: 3px;">
                        {{ $rule->description }} <span style="color: green;">+{{ $rule->score }}</span>
                        <span class="pointNum">{{ $rule->completed_times }}/{{ $rule->times }}</span>
                        <div class="am-progress am-progress-xs">
                            <div class="am-progress-bar am-progress-bar-success" style="width: {{ $rule->plan }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pointlist" style="padding: 0px 10px;">
                <div class="pointTitle">
                    <span>积分明细</span>
                </div>
                <table>
                    <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td class="pointType">{{ $log->description }}</td>
                            @if ($log->score > 0)
                                <td class="pointNum" style="color: green;">+ {{ $log->score }}</td>
                            @else
                                <td class="pointNum" style="color: red;">{{ $log->score }}</td>
                            @endif
                            <td class="pointTime">{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $logs->links() }}
            </div>

        </div>
    </div>
@endsection
