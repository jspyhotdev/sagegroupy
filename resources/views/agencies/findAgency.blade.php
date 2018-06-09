@extends('layouts.app')

@section('header-scripts')
    <script>
        window.Laravel.profile = <?php echo json_encode( $user ); ?>;
		window.sageSource.curPage = 'findAgencies';
    </script>
@endsection

@section('content')

        <md-whiteframe md-elevation="3" class=" padding-20 bg-white">


            <sage-agencies-list></sage-agencies-list>


            <div class="clearfix"></div>
        </md-whiteframe>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".sageImage").fancybox();
        });
    </script>
@endsection