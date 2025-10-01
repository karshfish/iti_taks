// src/interfaces/iaccount.ts
export interface IAccount {
  dateOfOpening: Date;

  addCustomer(customerName: string): void;
  removeCustomer(customerName: string): void;
}
