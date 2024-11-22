<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Jawaban_id</th>
            <th>Question_id</th>
            <th>Answer</th>
            <th>Created_at</th>
            <th>Updated_at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fetchAnswer as $answer)
            <tr>
                <td>{{ $answer->id }}</td>
                <td>{{ $answer->jawaban_id }}</td>
                <td>{{ $answer->question_id }}</td>
                <td>{{ $answer->answer }}</td>
                <td>{{ $answer->created_at }}</td>
                <td>{{ $answer->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
