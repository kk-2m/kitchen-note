document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('procedure-container');
    
    const deleteButtons = document.querySelectorAll('[id="delete-procedure"]');
        
    // forEachを使い各ボタンに対しての処理を設定
    deleteButtons.forEach(deleteButton => {
        // getAttributeを使ってdata-id取得
        const deleteId = deleteButton.getAttribute("data-id");
        console.log(`${deleteId}`);

        deleteButton.addEventListener('click', () => {
                const newProcedure = document.getElementById(`procedure${deleteId}`);
                container.removeChild(newProcedure);
        });
    });
    
});