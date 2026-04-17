@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Tasks
            </a>
        </div>

        <div class="glass-card">
            <div class="card-header-custom">
                <h2 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Task
                </h2>
                <p class="text-muted mb-0 mt-1">Update the task details below</p>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" id="edit-task-form">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold">
                        <i class="bi bi-type me-1"></i> Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control glass-input @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $task->title) }}" 
                           placeholder="Enter task title..."
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold">
                        <i class="bi bi-text-paragraph me-1"></i> Description
                    </label>
                    <textarea class="form-control glass-input @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="4" 
                              placeholder="Add a detailed description...">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-flag me-1"></i> Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select glass-input @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="priority" class="form-label fw-semibold">
                            <i class="bi bi-exclamation-circle me-1"></i> Priority <span class="text-danger">*</span>
                        </label>
                        <select class="form-select glass-input @error('priority') is-invalid @enderror" 
                                id="priority" 
                                name="priority" 
                                required>
                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="due_date" class="form-label fw-semibold">
                            <i class="bi bi-calendar-event me-1"></i> Due Date
                        </label>
                        <input type="date" 
                               class="form-control glass-input @error('due_date') is-invalid @enderror" 
                               id="due_date" 
                               name="due_date" 
                               value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-glow" id="btn-update-task">
                        <i class="bi bi-check-lg me-2"></i>Update Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
