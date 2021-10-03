const $editor = document.getElementById('editor')
if ($editor instanceof HTMLDivElement) {
  BalloonEditor.create($editor, {
    ckfinder: {
      uploadUrl: '/image/upload.php'
    }
  }).then(editor => {
    editor.editing.view.focus()
    const $form = document.querySelector('#main_form_post > form')
    $form.addEventListener('submit', e => {
      const data = document.createTextNode(editor.getData())
      document.querySelector('#main_form_post textarea[name=content]').appendChild(data)
    })
  })
}


const $readmore = document.getElementById('readmore');
if($readmore instanceof HTMLElement){
  let page=0;
  $readmore.addEventListener('click', () => {
    //index에 page를 get방식으로 요청을 한다 
    fetch('/?page=' + ++page, { method: 'get' }).then(async response => {
      try {
        
        // console.log('왜 안나오니');
        //console.log(await response.text());
        // var aa = await response.text();
        // console.log(aa);
        const parser = new DOMParser();
        const doc = parser.parseFromString(await response.text(), 'text/html');
        console.log(doc);
        const list = doc.querySelectorAll('.uk-container > .uk-list > li');
        console.log(list);
        if(list.length > 0){
          Array.from(list).forEach(async item => {
            reslut = await document.querySelector('.uk-container .uk-list').appendChild(item);
            console.log(reslut);
          })
        }
      } catch (error) {
        console.log(error);
      }

    });
  });
}