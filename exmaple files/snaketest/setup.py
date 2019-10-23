import cx_Freeze

executables = [cx_Freeze.Executable("Slither.py")]

cx_Freeze.setup(
    name="Slither",
    options={"build_exe":{"packages":["pygame"], "include_files":["apple.png", "snakehead.png", "snakeicon.png", 'CBlogo.png'] }},
    description = "slither, shneaky shnake",
    executables = executables
    )
