class Pippo {
    constructor() {
        console.log('Constructor Pippo');
    }
    hello(value) {
        console.log("Ciao " + value);
    }
}

class Pluto extends Pippo {

}

const p = new Pluto();
p.hello('Fabio');