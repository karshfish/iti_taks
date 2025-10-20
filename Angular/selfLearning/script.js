"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var greetings = "hello world";
console.log(greetings.toUpperCase());
//number
var firstNum = 23.3;
//bool
var firstbool = true;
//functions
function try_1(name, age, isregisterd) { }
;
// objects
var userOne = { name: 'fady', age: 12, idfinished: false };
function addUser(_a) {
    var string = _a.name, number = _a.age;
}
addUser(userOne);
function getPersn(pr) {
    console.log(pr.name);
}
getPersn({ name: 'fady', age: 12, email: 'fady@fady.com' });
var mimc = { name: 'mimicOne', age: 12, email: 'mimic@mim.com', hairColor: 'red' };
getPersn(mimc);
//arrays
var names = [];
names.push('fady');
//union types
var newUser;
