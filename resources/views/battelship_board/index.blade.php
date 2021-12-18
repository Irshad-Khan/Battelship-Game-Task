@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Battle Ships ') }}</div>

                <div class="card-body">
                    <div class="alert alert-success" style="display: none" role="alert" id="message"></div>

                    <div class="row">
                        <div class="col-md-8" id="your_board">
                            <h3>Your Base</h3>
                            <hr>
                            <?php
                                $count = 0;
                                $yAxis = ['A','B','C','D','E','F','G','H','I','J'];
                            ?>
                            <span style="margin-right: 21px; margin-left: 35px;">1</span>
                            <span style="margin-right: 21px">2</span>
                            <span style="margin-right: 21px">3</span>
                            <span style="margin-right: 21px">4</span>
                            <span style="margin-right: 21px">5</span>
                            <span style="margin-right: 21px">6</span>
                            <span style="margin-right: 21px">7</span>
                            <span style="margin-right: 21px">8</span>
                            <span style="margin-right: 25px">9</span>
                            <span>10</span>
                            <br/>
                            @for($i = 1; $i <= 10; $i++)
                                 <span style="margin-right: 25px;">{{ $yAxis[$i-1] }}</span>

                                @for($j = 1; $j <= 10; $j++)
                                    <span style="margin-right: 25px; font-weight: bolder" id="{{ $yAxis[$i-1].$j }}" class="xy-axis get_xy_cord" data-xy="{{ $yAxis[$i-1].$j }}">.</span>
                                @endfor
                                <br>
                            @endfor
                            <hr>
                            <div class="form-group">
                                <label for="xy">Enter coordinates (row, col), e.g. A5 and HIT ENTER</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="xy"
                                    placeholder="Enter coordinates (row, col), e.g. A5">
                            </div>
                        </div>
                        <div class="col-md-4" id="enemy_board">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.get_xy_cord').on('click', function(){
                let coordinate = $(this).data('xy')
                guessAjax(coordinate);
            });

            $("#xy").on('keyup', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    let coordinate = $(this).val();
                    guessAjax(coordinate);
                }
            });

            function guessAjax(coordinate){
                $.ajax({
                    type: "GET",
                    url: "/guess/coordinate/"+coordinate,
                    success: function (response) {
                        if(response.status == 'hit'){
                            $('#'+response.data).text('X')
                            $('#message').css('display','block');
                            $('#message').text(response.message);

                        }else if(response.status == 'miss'){
                            $('#'+response.data).text('-');
                            $('#message').css('display','block');
                            $('#message').text(response.message);
                        }else{
                            $('#message').css('display','block');
                            $('#message').text(response.message+' Total Shot:'+response.totalShot);
                        }
                    }
                });
            }
        });
    </script>
@stop
