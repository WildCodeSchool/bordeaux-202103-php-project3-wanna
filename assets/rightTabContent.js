const hashtag = window.location.hash;
console.log(hashtag);
if (hashtag) {
    let idNameTab = `v-pills-${hashtag.substring(1)}-tab`;
    let idNameContent = `v-pills-${hashtag.substring(1)}`;

    const currentTab = document.getElementById(idNameTab);
    const currentContent = document.getElementById(idNameContent);
    const changingTabs = document.getElementsByClassName('changingtab');
    const changingContents = document.getElementsByClassName('changingcontent');

    for (let changingTab of changingTabs) {
        changingTab.classList.remove('active');
    }
    currentTab.classList.add('active');

    for (let changingContent of changingContents) {
        changingContent.classList.remove('show');
        changingContent.classList.remove('active');
    }
    currentContent.classList.add('active');
    currentContent.classList.add('show');
}



