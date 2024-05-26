@foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>{{ $user->status }}</td>
        <td>
            <form action="{{ route('users.update-role', $user) }}" method="POST">
                @csrf
                <select name="role">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                    <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Кассир</option>
                </select>
                <button type="submit">Изменить роль</button>
            </form>
            <form action="{{ route('users.update-status', $user) }}" method="POST">
                @csrf
                <select name="status">
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Активный</option>
                    <option value="blocked" {{ $user->status == 'blocked' ? 'selected' : '' }}>Заблокирован</option>
                </select>
                <button type="submit">Изменить статус</button>
            </form>
        </td>
    </tr>
@endforeach
