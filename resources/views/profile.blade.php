@extends('layouts.app')

@section('content')



<div class="container  mx-auto p-8 rounded-lg mt-4 border">
    <div class="col-8 container mx-auto">
        @if(Session::has('message'))
        <div class="alert alert-success p-4 capitalize mb-6 bg-green-100 rounded-lg">
            {{Session::get('message')}}
        </div>
        @endif
    <form class="form" action="{{ Request('pass') ? '/profile?pass=true' : '/profile'}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-1/4 mb-4">
                <div class="form-group d-flex justify-content-center ">
                    
                    <div class="file-upload flex items-center gap-6">
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="User Avatar"  id="av" class="ring-2 ring-2-blue-500 object-cover rounded-full !h-[100px] !w-[100px]" >
                        <div>
                        <div class="upload-text font-bold">Change avatar ?</div>
                    <input id="av-input" name="avatar" type="file" value="{{old('avatar') ?? Auth::user()->avatar}}" class="text-sm file-input @error('avatar')  border border-red  @enderror">
                    </div>
                    </div>
                </div> 
            </div>
            <div class="w-2/3">
            <div class="flex items-center space-x-8">
            <div class="mb-4 w-1/2">
                <label for="name">Name</label>
                <input name="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border border-red  @enderror"  value="{{ old('name') ?? Auth::user()->name}}" placeholder="Enter your name">
                @error('name')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-4 w-1/2">
                <label for="uname">Username</label>
                <input name="uname" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('uname')  border border-red  @enderror" value="{{ old('uname') ?? Auth::user()->uname}}"  placeholder="User name">
                @error('uname')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
            </div>
            
            <div class="mb-4">
                <label for="email">Email</label>
                <input name="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email')  border border-red  @enderror"  value="{{ old('email') ?? Auth::user()->email}}" placeholder="foulen@fou.com">
                @error('email')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mb-4">
                @if(Request('pass'))
                <label for="name">Old Password</label>

                @else
                <label for="name">Password</label>

                @endif
                <input name="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password')  border border-red  @enderror"   placeholder="Enter your Password">
                @error('password')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror  
            </div>

            @if(Request('pass'))
            <div class="flex items-center space-x-8">
            <div class="mb-4 w-1/2">
                <label for="name">New Confirmation</label>
                <input name="new_password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline  @error('new_password')  border border-red  @enderror"   placeholder="Confirm your Password">
                @error('new_password')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror   
            </div>
            <div class="mb-4 w-1/2">
                <label for="name">New Password Confirmation</label>
                <input name="new_password_confirmation" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline  @error('new_password_confirmation')  border border-red  @enderror"   placeholder="Confirm your Password">
                @error('new_password_confirmation')
                <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror   
            </div>
            </div>
            @else 
                <div class="mb-4">

                    <a href="?pass=true" class="bg-yellow-500 text-sm hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline capitalize">update password ?</a>
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"> Save </button>
            </div>
            </div>
        </form>
    </div>
</div>


<script>
        // display chosen avatar

        document.getElementById('av-input').addEventListener('change' , (e)=>{
        var reader = new FileReader();
    
            reader.onload = function (e) {
                document.getElementById('av').src= e.target.result;
            }
        reader.readAsDataURL(document.getElementById('av-input').files[0]);
        // console.log(e.target.result);
        // document.getElementById('av').src = e.target.file[0]
    });

</script>


@endsection
