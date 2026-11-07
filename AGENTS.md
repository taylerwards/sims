# Project guidance for Codex

Before making project changes, read [`.codex/PROJECT_MEMORY.md`](.codex/PROJECT_MEMORY.md) for the durable project context and recent change history. Use [`.codex/PROJECT_PLAN.md`](.codex/PROJECT_PLAN.md) as the source of truth for SIMS requirements and agreed implementation decisions.

After completing a task that changes project files, append a concise dated entry to `.codex/PROJECT_MEMORY.md`. Record the purpose, important files changed, and validation performed (or state that none was run). Keep older entries; do not replace the history. Never copy secrets, credentials, or `.env` values into the memory file.

Keep the memory accurate by checking the actual working tree. Do not infer undocumented requirements or claim validation that was not performed.
