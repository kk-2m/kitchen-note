document.addEventListener('DOMContentLoaded', function () {
    // id属性が"delete_button"で始まるすべてのボタン要素を取得
    // `^`は「〜で始まる」という意味
    const deleteButtons = document.querySelectorAll('[id^="delete_button"]');
    
    // forEachを使い各ボタンに対しての処理を設定
    deleteButtons.forEach(deleteButton => {
        // getAttributeを使ってdata-id取得
        const deleteId = deleteButton.getAttribute("data-id");
        console.log(`${deleteId}`);

        deleteButton.addEventListener('click', () => {
            'use strict';
            console.log("enter the function");
            
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${deleteId}`).submit();
                console.log(`削除処理事項`);
            }
        });
    });
});