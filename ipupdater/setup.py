import cx_Freeze

executables = [cx_Freeze.Executable("ip updater.py")]

cx_Freeze.setup(
    name="ipcapture",
    options={"build_exe":{"packages":["gspread", "oauth2client", "APScheduler", "idna", "requests", "six", "pytz", "tzlocal"], "include_files":["details.json"]}},
    description="comment here",
    executables = executables
)