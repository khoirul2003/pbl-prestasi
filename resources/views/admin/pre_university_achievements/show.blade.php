<table class="table table-bordered">
    <tbody>
        <tr>
            <th>Student</th>
            <td>{{ $preUniversityAchievement->user->user_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $preUniversityAchievement->category->category_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $preUniversityAchievement->pre_university_achievement_title }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $preUniversityAchievement->pre_university_achievement_description ?? '-' }}</td>
        </tr>
        <tr>
            <th>Ranking</th>
            <td>{{ $preUniversityAchievement->pre_university_achievement_ranking ?? '-' }}</td>
        </tr>
        <tr>
            <th>Level</th>
            <td>{{ ucfirst($preUniversityAchievement->pre_university_achievement_level ?? '-') }}</td>
        </tr>
        <tr>
            <th>Document</th>
            <td>
                @if ($preUniversityAchievement->pre_university_achievement_document)
                    <a href="{{ asset('storage/' . $preUniversityAchievement->pre_university_achievement_document) }}" target="_blank">
                        View Document
                    </a>
                @else
                    No document uploaded.
                @endif
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $preUniversityAchievement->created_at->format('d M Y H:i') }}</td>
        </tr>
    </tbody>
</table>
