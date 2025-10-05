let greetings: string = "hello world";
console.log(greetings.toUpperCase());
//number
let firstNum: number = 23.3;
//bool
let firstbool: boolean = true;
//functions
function try_1(name:string, age:number,
    isregisterd:boolean){};
// objects
let userOne={name:'fady', age:12,idfinished:false };
function addUser({name:string, age:number}){}
addUser(userOne);
//type aliases 
interface person {
    name:string;
    age:number;
    email:string
}
function getPersn(pr:person){
    console.log(pr.name)
}

getPersn({name:'fady',age:12,email:'fady@fady.com'})
let mimc={name:'mimicOne',age:12,email:'mimic@mim.com',hairColor:'red'};
getPersn(mimc);
type user={
    readonly id: number; //can't be changed
    name: string;
    creditNum?: number //can have it or can't
};
//arrays
const names: string[]=[];
names.push('fady');
//union types
let newUser: user|person;
export {};
