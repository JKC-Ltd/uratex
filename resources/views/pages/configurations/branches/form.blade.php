<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($branch) ? 'Edit Branch' : 'Create Branch' }}
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <form method="POST"
                    action="{{ isset($branch) ? route('branches.update', $branch->id) : route('branches.store') }}">
                    @csrf
                    @if (isset($branch))
                        @method('PUT')
                    @endif
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="branchName">Branch Name</label>
                                        <input type="text" class="form-control @error('name') input-error @enderror" id="branchName"
                                            name="name"
                                            value="{{ old('name', isset($branch) ? $branch->name : '') }}"
                                            placeholder="Branch Name" required>
                                        @error('name')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="branchCode">Branch Code</label>
                                        <input type="text" class="form-control @error('branch_code') input-error @enderror" id="branchCode"
                                            name="branch_code"
                                            value="{{ old('branch_code', isset($branch) ? $branch->branch_code : '') }}"
                                            placeholder="Branch Code">
                                        @error('branch_code')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('branches.index') }}"><button type="button"
                                    class="btn btn-danger">Cancel</button></a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($branch) ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>
