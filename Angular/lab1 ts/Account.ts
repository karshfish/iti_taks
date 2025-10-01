// src/models/Account.ts
import { IAccount } from './iaccount';

export abstract class Account implements IAccount {
  public accNo: number;
  protected balance: number;
  public dateOfOpening: Date;
  protected customers: string[] = [];

  constructor(accNo: number, balance: number, dateOfOpening: Date) {
    this.accNo = accNo;
    this.balance = balance;
    this.dateOfOpening = dateOfOpening;
  }

  // IAccount methods
  public addCustomer(customerName: string): void {
  if (this.customers.indexOf(customerName) === -1) {
    this.customers.push(customerName);
  }
}


  public removeCustomer(customerName: string): void {
    this.customers = this.customers.filter(c => c !== customerName);
  }

  // Account operations
  /**
   * Debit amount from account.
   * Returns true if successful, false if insufficient funds (or subclass rules).
   */
  public debitAmount(amount: number): boolean {
    if (amount <= 0) return false;
    if (amount <= this.balance) {
      this.balance -= amount;
      return true;
    }
    return false;
  }

  public creditAmount(amount: number): void {
    if (amount > 0) {
      this.balance += amount;
    }
  }

  public getBalance(): number {
    return this.balance;
  }
}
