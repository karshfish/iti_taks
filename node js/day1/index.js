#!/usr/bin/env node

const fs = require("fs");
const path = require("path");

const DATA_FILE = path.join("todos.json");

// Initialize data file if it doesn't exist
function initializeDataFile() {
  if (!fs.existsSync(DATA_FILE)) {
    fs.writeFileSync(DATA_FILE, JSON.stringify([]), "utf8");
  }
}

// Read entries from JSON file
function readEntries() {
  initializeDataFile();
  const data = fs.readFileSync(DATA_FILE, "utf8");
  return JSON.parse(data);
}

// Write entries to JSON file
function writeEntries(entries) {
  fs.writeFileSync(DATA_FILE, JSON.stringify(entries, null, 2), "utf8");
}

// Get next available ID
function getNextId(entries) {
  if (entries.length === 0) {
    return 1;
  }
  const maxId = Math.max(...entries.map((entry) => entry.id));
  return maxId + 1;
}

// Add a new entry
function addEntry(title) {
  const entries = readEntries();
  const newEntry = {
    id: getNextId(entries),
    title: title,
    status: "to-do",
  };
  entries.push(newEntry);
  writeEntries(entries);
  console.log(`✓ Entry added successfully with ID: ${newEntry.id}`);
  console.log(`  Title: "${newEntry.title}"`);
  console.log(`  Status: ${newEntry.status}`);
}

// List entries (all or filtered by status)
function listEntries(status) {
  const entries = readEntries();

  let filteredEntries = entries;
  if (status) {
    filteredEntries = entries.filter((entry) => entry.status === status);
  }

  if (filteredEntries.length === 0) {
    if (status) {
      console.log(`No entries found with status "${status}"`);
    } else {
      console.log("No entries found");
    }
    return;
  }

  console.log("\n📋 To-Do List:\n");
  filteredEntries.forEach((entry) => {
    console.log(`ID: ${entry.id}`);
    console.log(`Title: ${entry.title}`);
    console.log(`Status: ${entry.status}`);
    console.log("---");
  });
  console.log(`Total: ${filteredEntries.length} entry(ies)\n`);
}

// Edit an entry
function editEntry(id, title, status) {
  const entries = readEntries();
  const entryIndex = entries.findIndex((entry) => entry.id === parseInt(id));

  if (entryIndex === -1) {
    console.log(`✗ Entry with ID ${id} not found`);
    return;
  }

  if (title) {
    entries[entryIndex].title = title;
  }

  if (status) {
    const validStatuses = ["to-do", "in progress", "done"];
    if (!validStatuses.includes(status)) {
      console.log(
        `✗ Invalid status. Must be one of: ${validStatuses.join(", ")}`
      );
      return;
    }
    entries[entryIndex].status = status;
  }

  writeEntries(entries);
  console.log(`✓ Entry ${id} updated successfully`);
  console.log(`  Title: "${entries[entryIndex].title}"`);
  console.log(`  Status: ${entries[entryIndex].status}`);
}

// Delete an entry
function deleteEntry(id) {
  const entries = readEntries();
  const entryIndex = entries.findIndex((entry) => entry.id === parseInt(id));

  if (entryIndex === -1) {
    console.log(`✗ Entry with ID ${id} not found`);
    return;
  }

  const deletedEntry = entries[entryIndex];
  entries.splice(entryIndex, 1);
  writeEntries(entries);
  console.log(`✓ Entry ${id} deleted successfully`);
  console.log(`  Deleted: "${deletedEntry.title}"`);
}

// Parse command line arguments
function parseArguments(args) {
  const command = args[2];
  const params = args.slice(3);

  return { command, params };
}

// Parse flags from arguments
function parseFlags(params) {
  const flags = {};
  let positionalArgs = [];

  for (let i = 0; i < params.length; i++) {
    const param = params[i];

    if (param === "-s" || param === "--status") {
      flags.status = params[i + 1];
      i++;
    } else if (param === "-t" || param === "--title") {
      flags.title = params[i + 1];
      i++;
    } else if (param === "--id") {
      flags.id = params[i + 1];
      i++;
    } else if (!param.startsWith("-")) {
      positionalArgs.push(param);
    }
  }

  return { flags, positionalArgs };
}

// Show help message
function showHelp() {
  console.log(`
To-Do List CLI - Usage:

Add a new entry:
  node index.js add "Your task title"

List all entries:
  node index.js list

List entries by status:
  node index.js list -s "done"
  node index.js list --status "to-do"

Edit entry (required features):
  node index.js edit 123 "New title"

Edit entry (bonus features):
  node index.js edit --id 123 -t "New title"
  node index.js edit --id 123 -s "done"
  node index.js edit --id 123 -t "New title" -s "in progress"

Delete an entry:
  node index.js delete 123

Valid status values: "to-do", "in progress", "done"
  `);
}

// Main execution
function main() {
  const args = process.argv;
  const { command, params } = parseArguments(args);

  if (!command || command === "help") {
    showHelp();
    return;
  }

  switch (command) {
    case "add":
      if (params.length === 0) {
        console.log("✗ Please provide a title for the entry");
        console.log('Example: node index.js add "Your task"');
        return;
      }
      addEntry(params[0]);
      break;

    case "list":
      const { flags: listFlags } = parseFlags(params);
      listEntries(listFlags.status);
      break;

    case "edit":
      const { flags: editFlags, positionalArgs } = parseFlags(params);

      if (positionalArgs.length >= 2) {
        editEntry(positionalArgs[0], positionalArgs[1]);
      } else if (editFlags.id) {
        if (!editFlags.title && !editFlags.status) {
          console.log(
            "✗ Please specify at least one of: -t (title) or -s (status)"
          );
          return;
        }
        editEntry(editFlags.id, editFlags.title, editFlags.status);
      } else {
        console.log("✗ Please provide an ID and at least title or status");
        console.log("Examples:");
        console.log('  node index.js edit 123 "New title"');
        console.log('  node index.js edit --id 123 -t "New title" -s "done"');
      }
      break;

    case "delete":
      if (params.length === 0) {
        console.log("✗ Please provide an ID to delete");
        console.log("Example: node index.js delete 123");
        return;
      }
      deleteEntry(params[0]);
      break;

    default:
      console.log(`✗ Unknown command: ${command}`);
      showHelp();
  }
}

// Run the application
main();
