@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }} ok
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> -->

<style>
.demo_product button{

    background-color:gray;
    color:white;
}
</style>
<div class=" bg-white mb-5">

    <div class="container my-5 mx-4" style=" max-height: auto; ">
            <div class="row px-5 py-5 flex items-stretch">

                <div class="col-md-12 justify-content-center">
                          <div id="submit_botton" align="center">
                               <a href="{{ url('auth/google') }}"><button  role="button" class=" mt-3 btn formuaire_payement" style="background-color: #ea580c; color:white;">Connect to Google Drive</button></a> 
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-5"></div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script type="text/javascript">

</script>
@endsection
