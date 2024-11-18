@props(['number'])

<div class="flex flex-col my-10">
    <label for="images" class="mb-1 text-gray-700 text-md font-semibold">画像{{ $number }}を追加する</label>
    <p class="mb-4 text-xs">※1枚あたりのサイズは2MBまで</p>
    <input type="file" name="images[{{ $number - 1 }}]" id="images" accept="image/*">
</div>