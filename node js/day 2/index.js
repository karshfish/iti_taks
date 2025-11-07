#!/usr/bin/env node
const express = require("express");
const fs = require("fs");
const path = require("path");

const app = express();
const PORT = 3000;

const DATA_FILE = path.join(__dirname, "todos.json");

app.use(express.json());

// ===== Helper functions =====
function initializeDataFile() {
  if (!fs.existsSync(DATA_FILE)) {
    fs.writeFileSync(DATA_FILE, JSON.stringify([]), "utf8");
  }
}

function readEntries() {
  initializeDataFile();
  const data = fs.readFileSync(DATA_FILE, "utf8");
  return JSON.parse(data);
}

function writeEntries(entries) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(entries, null, 2), "utf8");
}

function getNextId(entries) {
  return entries.length === 0 ? 1 : Math.max(...entries.map((t) => t.id)) + 1;
}

// ===== Routes =====

// Create new todo
app.post("/todos", (req, res) => {
  const { title } = req.body;
  if (!title) return res.status(400).json({ error: "Title is required" });

  const entries = readEntries();
  const newTodo = { id: getNextId(entries), title, status: "to-do" };
  entries.push(newTodo);
  writeEntries(entries);

  res.status(201).json(newTodo);
});

// Edit todo
app.patch("/todos/:id", (req, res) => {
  const { id } = req.params;
  const { title, status } = req.body;

  const entries = readEntries();
  const todo = entries.find((t) => t.id === parseInt(id));

  if (!todo) return res.status(404).json({ error: "Todo not found" });

  if (title) todo.title = title;
  if (status) {
    const validStatuses = ["to-do", "in progress", "done"];
    if (!validStatuses.includes(status)) {
      return res
        .status(400)
        .json({
          error: `Invalid status. Must be one of: ${validStatuses.join(", ")}`,
        });
    }
    todo.status = status;
  }

  writeEntries(entries);
  res.json(todo);
});

// Delete todo
app.delete("/todos/:id", (req, res) => {
  const { id } = req.params;
  const entries = readEntries();
  const index = entries.findIndex((t) => t.id === parseInt(id));

  if (index === -1) return res.status(404).json({ error: "Todo not found" });

  const deleted = entries.splice(index, 1)[0];
  writeEntries(entries);
  res.json({ message: "Todo deleted", deleted });
});

// Get todos with limit & skip
app.get("/todos", (req, res) => {
  const { limit = 10, skip = 0 } = req.query;

  const entries = readEntries();
  const limited = entries.slice(
    parseInt(skip),
    parseInt(skip) + parseInt(limit)
  );

  res.json({
    total: entries.length,
    limit: parseInt(limit),
    skip: parseInt(skip),
    data: limited,
  });
});

// Get one todo by ID
app.get("/todos/:id", (req, res) => {
  const { id } = req.params;
  const entries = readEntries();
  const todo = entries.find((t) => t.id === parseInt(id));

  if (!todo) return res.status(404).json({ error: "Todo not found" });
  res.json(todo);
});

// ===== Start server =====
app.listen(PORT, () =>
  console.log(`🚀 Server running on http://localhost:${PORT}`)
);
