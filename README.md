# watson-srt-subtitle
Convert the JSON result of IBM Watson Speech to Text service to an SRT subtitle file.  

The IBM Watson Speech to Text service can be used to create subtitles for videos if your request has set `timestamps=true`. However, the returned result is in JSON format and requires some conversion. That's exactly what these scripts do.