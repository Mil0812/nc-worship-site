<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string|null $image
 * @property-read string $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SetList> $setLists
 * @property-read int|null $set_lists_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\BandFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Band whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBand {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $user_id
 * @property string $commentable_type
 * @property string $commentable_id
 * @property string $content
 * @property string|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read Comment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment root()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperComment {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $user_id
 * @property string $song_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Song $song
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\FavouriteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite whereSongId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favourite whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFavourite {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string|null $icon
 * @property-read string $icon_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tutorial> $tutorials
 * @property-read int|null $tutorials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\InstrumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instrument whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperInstrument {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property \App\Enums\OriginalKey $key
 * @property string $audio
 * @property-read string|null $audio_url
 * @property-read \App\Models\SetListSong|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SetList> $setListSongs
 * @property-read int|null $set_list_songs_count
 * @method static \Database\Factories\PadFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad whereAudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pad whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPad {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $band_id
 * @property \Illuminate\Support\Carbon|null $performed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Band $band
 * @property-read \App\Models\SetListSong|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Song> $songs
 * @property-read int|null $songs_count
 * @method static \Database\Factories\SetListFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList whereBandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList wherePerformedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSetList {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $set_list_id
 * @property string $song_id
 * @property int $number
 * @property string|null $leader_id
 * @property \App\Enums\OriginalKey $key
 * @property string $pad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $leader
 * @property-read \App\Models\Pad $pad
 * @property-read \App\Models\SetList $setList
 * @property-read \App\Models\Song $song
 * @method static \Database\Factories\SetListSongFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereLeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong wherePadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereSetListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereSongId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SetListSong whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSetListSong {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $author
 * @property \App\Enums\SongType $type
 * @property string|null $image
 * @property \App\Enums\OriginalKey $original_key
 * @property int $bpm
 * @property \App\Enums\TimeSignature|null $time_signature
 * @property string|null $audio
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favourite> $favorites
 * @property-read int|null $favorites_count
 * @property-read string $audio_url
 * @property-read string $image_url
 * @property-read \App\Models\SetListSong|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SetList> $setLists
 * @property-read int|null $set_lists_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SongSection> $songSections
 * @property-read int|null $song_sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tutorial> $tutorials
 * @property-read int|null $tutorials_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song byBpmRange(int $min, int $max)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song byKey(\App\Enums\OriginalKey $key)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song bySlug(string $slug)
 * @method static \Database\Factories\SongFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereAudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereBpm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereOriginalKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereTimeSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Song whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSong {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property \App\Enums\SongSectionType $section_type
 * @property int $order
 * @property string $lyrics
 * @property string|null $chords
 * @property string $song_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Song $song
 * @method static \Database\Factories\SongSectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereChords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereLyrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereSectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereSongId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SongSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSongSection {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $slug
 * @property string $song_id
 * @property string|null $instrument_id
 * @property string $video
 * @property string|null $description
 * @property bool $is_public
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Instrument|null $instrument
 * @property-read \App\Models\Song $song
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial bySlug(string $slug)
 * @method static \Database\Factories\TutorialFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereInstrumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereSongId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tutorial whereVideo($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTutorial {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $last_name
 * @property \App\Enums\Role $role
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string|null $telegram_id
 * @property bool $receive_notifications
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Band> $bands
 * @property-read int|null $bands_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favourite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Instrument> $instruments
 * @property-read int|null $instruments_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User byRole(\App\Enums\Role $role)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereReceiveNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

