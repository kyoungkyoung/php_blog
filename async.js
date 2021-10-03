// Promise is a JavaScript object for asynchronous operation. //비동기적인것을 수행할 때 콜백함수 대신 유용하게 쓸 수 있는 Object
//  - State: pending -> fulfilled or rejected //현재 상태가 기능 수행이 되는중인지(pending), 성공(fulfilled)했는지 실패(rejected)했는지
//  - Producer vs Consumer

// 1. Producer
// when new Promise is created, the executor runs automatically
const promise = new Promise((resolve, reject) => {
    // doing some heavy work (network, read files)
    console.log('doing somthing...');
    setTimeout(() => {
        //resolve('ellie'); // 기능을 성공적으로 수행했다면 resolve함수를 호출한다.
        reject(new Error('no network'));
    }, 2000);
});

// 2. Consumers: then, catch, finally
// 값이 정상적으로 수행이 된다면, then, 그럼 내가 어떠한 값(value)를 받아와서 원하는 기능을 수행하는 콜백함수를 전달해준다.
// 이때 값(value)은 resolve에서 넘겨준 'ellie'이다.

promise
.then((value) => {
    console.log(value); //2초뒤에 ellie가 출력된다
})
.catch(error => {
    console.log(error);
})
.finally(() => {
    console.log('finally'); //성공 실패 여부와 상관없이 항상 호출된다.
});

