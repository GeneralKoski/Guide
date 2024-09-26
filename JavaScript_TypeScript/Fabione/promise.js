const p = new Promise((resolve, reject) => {
    setTimeout(() => resolve(5), 3000);
});

p.then(
    () => new Promise((resolve, reject) => {
        setTimeout(() => resolve(50), 3000);
    }),
).then (
    data => console.log(data),
).catch(
    err => console.log(err)
);