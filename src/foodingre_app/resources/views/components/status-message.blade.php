@php
if(session('status') === 'info') { $bgColor = 'bg-blue-500';}
if(session('status') === 'alert') { $bgColor = 'bg-red-800';}
@endphp

@if(session('message'))
<div id="statusMessage" class="{{ $bgColor }} w-full h-6">
    <div class="max-w-7xl mx-auto flex justify-start text-white">
        {{ session('message') }}
    </div>
</div>
@endif

<script>
    'use strict';
    // ステータスメッセージの設定
    const statusMessage = document.getElementById('statusMessage');
    if(statusMessage) {
        setTimeout(function() {
            document.getElementById('statusMessage').style.display = 'none';
        }, 5000); 
    }
</script>