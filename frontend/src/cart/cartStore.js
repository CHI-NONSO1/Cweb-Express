export default class Table {
  constructor(key, value) {
    this.key = key;
    this.value = value;
    this.next = null;
    this.cells = new Array(1000);
  }
  hash(key) {
    let total = 0;
    for (let i = 0; i < key.length; i++) {
      total += key.charCodeAt(i);
    }
    return total % this.cells.length;
  }
  insert(key, value) {
    let hash = this.hash(key);
    if (!this.cells[hash]) {
      this.cells[hash] = new Table(key, value);
    } else {
      this.cells[hash].next += 1;
    }
  }

  getItem(key) {
    const hash = this.hash(key);

    if (this.cells[hash].key === key && this.cells[hash].next !== null) {
      let item = this.cells[hash].value;
      let quantity = this.cells[hash].next;
      let cart = { item, quantity };
      return cart;
    } else {
      if (this.cells[hash].key === key) {
        return this.cells[hash].value;
      }
    }
  }

  getAll() {
    return this;
  }
}
