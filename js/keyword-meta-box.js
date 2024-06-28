document.addEventListener('DOMContentLoaded', () => {
    let keywords = [];
    const addButton = document.querySelector('#keyword-add');
    const newKeywordInput = document.querySelector('#keyword-new');
    const keywordList = document.querySelector('#keyword-list');
    const postKeywordsInput = document.querySelector('#post-keywords');

    const existingKeywords = postKeywordsInput.value.split(';').filter(keyword => keyword.trim() !== '');
    existingKeywords.forEach(keyword => displayKeyword(keyword));

    addButton.addEventListener('click', () => {
        const keyword = newKeywordInput.value.trim();

        if (!keyword) return;

        if (keywords.includes(keyword)) {
            alert("Keyword already exists");
            return;
        }

        displayKeyword(keyword);
        newKeywordInput.value = '';
    });

    function displayKeyword(keyword) {
        const listItem = document.createElement('li');
        listItem.textContent = `${keyword} `;

        const removeButton = document.createElement('span');
        removeButton.classList.add('keyword-remove');
        removeButton.textContent = 'x';

        function updateKeywords() {
            postKeywordsInput.value = keywords.join(";");
        }

        removeButton.addEventListener('click', () => {
            keywordList.removeChild(listItem);
            keywords = keywords.filter(savedKeyword => savedKeyword !== keyword);
            updateKeywords();
        });

        listItem.appendChild(removeButton);
        keywordList.appendChild(listItem);
        keywords.push(keyword);
        updateKeywords();
    }
});
