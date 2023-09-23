import sys
import json

def float_to_time_string(float_time: float) -> str:
    hours = int(float_time / 3600)
    minutes = int((float_time / 60) % 60)
    seconds = int(float_time % 60)
    milliseconds = round((float_time - int(float_time)) * 1000)

    return f"{hours:02d}:{minutes:02d}:{seconds:02d},{milliseconds:03d}"

def mstime_to_srttime(start: float, end: float) -> str:
    start_time_string = float_to_time_string(start)
    end_time_string = float_to_time_string(end)

    return f"{start_time_string} --> {end_time_string}"


if len(sys.argv) < 2:
    print("No file provided")
    sys.exit(0)

filename = sys.argv[1]
with open(filename, "r", encoding="utf-8") as f:
    json_data = json.load(f)

output = ""
for i, result in enumerate(json_data["results"]):
    sub = result["alternatives"][0]
    text = sub["transcript"]
    time_start = sub["timestamps"][0][1]
    time_end = sub["timestamps"][-1][2]

    index = i + 1
    timestr = mstime_to_srttime(time_start, time_end)
    output += f"{index}\n{timestr}\n{text}\n\n"

with open(f"{filename}.srt", "w", encoding="utf-8") as f:
    f.write(output)

print(f"Done, output written to {filename}.srt")